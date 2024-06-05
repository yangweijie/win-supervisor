<?php

namespace app\journal\home;

use think\admin\Service\QueueService;
use app\journal\model\Journal;
use app\journal\model\JournalContent;
use Symfony\Component\DomCrawler\Crawler;


use Jaeger\GHttp;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

use League\CommonMark\CommonMarkConverter;

use util\Http;

class Cron extends QueueService
{

	static $ua  = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36';

	public function execute(array $data = [])
	{
		try {
			$todos = Journal::where('status', 1)->select();
			// $todos = range(1,50);
			$total = count($todos);
			$done  = 0;
			foreach ( $todos as $todo) {
				if($todo['type'] == 'rss'){
					;
				}else{
					$response = Http::get($todo['url']);
					if($response){
						$crawler = new Crawler($response);
						$list    = $crawler->filter($todo['rule']['list_selector'])->each(function ($node, $i) use ($todo) {
							$link = self::absoluteUrl($todo['url'], $node->attr('href'));
							if(isset($todo['rule']['list_href_replace']) && $todo['rule']['list_href_replace']){
	                            $list_href_replace = $todo['rule']['list_href_replace'];
	                            $link = str_ireplace($list_href_replace, '', $link);
	                        }
						    return ['title' => $node->text(), 'link'=>$link, 'sort'=>$i];
						});
						if($list){
							trace("count list:".count($list));
							trace("todo count:".$todo['total']);
							if(count($list) != $todo['total'] || !JournalContent::where('title', $list[0]['title'])->where('journal_id', $todo['id'])->find()){
								$to_sync = array_diff(array_column($list, 'title'), JournalContent::where('journal_id', $todo['id'])->column('title')?:[]);
								$this->progress(2, "{$todo['title']} 有".count($to_sync).'个待同步');
								if($to_sync){
									ptrace($to_sync);
									trace($to_sync);
								}

								$to_sync_list = [];
								$total_list   = count($list);
								foreach ($list as $value) {
									if(in_array($value['title'], $to_sync)){
										$value['sort']  = $total_list - $value['sort'];
										$to_sync_list[] = $value;
									}
								}

								try {
							    	$urls = array_column($to_sync_list, 'link');
							    	// trace(count($urls));
							    	GHttp::multiRequest($urls)
							    		->withOptions([
							    			'force_ip_resolve' => 'v4',
							                'verify'           => false,
							                'headers'          => [
							                    'User-Agent' => self::$ua,
							                ],
							                'allow_redirects' => true,
							                'timeout'         => 60,
							    		])->concurrency(random_int(20, 200))->success(function(Response $response, $index) use($urls, $to_sync_list, $todo){
							    		// trace('in');
									    $content = (String) $response->getBody();
									    if($content){
									    	ptrace("{$urls[$index]}的相应为".PHP_EOL.$content);
									    	trace("{$urls[$index]}的相应为".PHP_EOL.$content);
									    }
								        $crawler = new Crawler($content);
										try {
											$new_content = $crawler->filter($todo['rule']['content_selector'])->eq(0)->outerHtml();
											if(isset($todo['rule']['content_md']) && $todo['rule']['content_md']){
				                                $converter = new CommonMarkConverter([
				                                    'html_input'         => 'strip',
				                                    'allow_unsafe_links' => false,
				                                ]);

				                                $new_content = $converter->convertToHtml($new_content);
				                            }
											$new_content = filter_Emoji($new_content);
											JournalContent::create([
												'title'      => $to_sync_list[$index]['title'],
												'content'    => $new_content,
												'sort'       => $to_sync_list[$index]['sort'],
												'url'        => $to_sync_list[$index]['link'],
												'journal_id' => $todo['id'],
											]);
										} catch (\Exception $e) {
											ptrace(sprintf('%s中%s 的dom节点无法为获取，正文：%s', $to_sync_list[$index]['link'], $todo['rule']['content_selector'], $content));
											trace(sprintf('%s中%s 的dom节点无法为获取，正文：%s', $to_sync_list[$index]['link'], $todo['rule']['content_selector'], $content));
											trace(short_exception($e));
										}
									})->error(function(RequestException $reason, $index) use ($to_sync_list){
										$response_json = json_encode($reason, JSON_UNESCAPED_UNICODE);
										ptrace("{$to_sync_list[$index]['title']}-{$to_sync_list[$index]['link']}的正文获取失败：{$response_json}");
										trace("{$to_sync_list[$index]['title']}-$to_sync_list[$index]['link']的正文获取失败：{$response_json}");
									})->get();
						        } catch (\Exception $e) {
						        	ptrace($e->getMessage() . PHP_EOL . $e->getTraceAsString());
						        	trace($e->getMessage() . PHP_EOL . $e->getTraceAsString());
						        }
								$todo->sync_time = datetime();
								$todo->total     = JournalContent::where('journal_id', $todo['id'])->count();
								$todo->save();
							}
							$string  = str_pad(++$done, strlen((string)$total), '0', STR_PAD_LEFT);
							$message = "({$string}/{$total}) -> $done";
							$this->progress(2, $message, $done * 100 / $total);
						}else{
							$this->progress(2, "{$todo['id']}的期刊列表选择器无效");
							goto fail;
						}
					}else{
						fail:
						ptrace('error:'.cache("http_{$todo['url']}"));
						$this->progress(2, "{$todo['id']}的期刊列表获取失败");
					}
				}
			}
			return "同步{$total}个数据结束, 成功{$done}个";
		} catch (\Exception $e) {
			ptrace(short_exception($e));
			$this->progress(2, short_exception($e));
			$this->progress(4, short_exception($e));
		}
	}

    // 转换采集的绝对路径为相对路径
    public static function absoluteUrl($domain, $url)
    {
        if (stripos($url, 'http') !== false) {
            return $url;
        }

        static $rdomain_arr = [];
        if (isset($rdomain_arr[$domain])) {
            $domain_arr = $rdomain_arr[$domain];
        } else {
            $domain_arr = parse_url($domain);
            if ($domain_arr) {
                $rdomain_arr[$domain] = $domain_arr;
            }
        }
        if (false === $domain_arr) {
            exception($domain . '为错误的url格式');
        }
        $last = str_ireplace("{$domain_arr['scheme']}://" . $domain_arr['host'], '', $domain);
        if ($last && false !== stripos($url, $last)) {
            $domain = $domain_arr['host'];
        }
        // $domain            = $domain_arr['host'];
        $domain_end_splash = false;
        if (strlen($domain) !== rtrim($domain, '/')) {
            $domain_end_splash = true;
        }
        $url_start_splash = false;
        if ($url[0] == '/') {
            $url_start_splash = true;
        }
        if (!$domain_end_splash && !$url_start_splash) {
            $splash = '/';
        } else {
            $splash = '';
        }
        $target = str_ireplace("{$domain_arr['scheme']}://", '', $domain . $splash . $url);
        return "{$domain_arr['scheme']}://" . str_ireplace('//', '/', $target);
    }
}
