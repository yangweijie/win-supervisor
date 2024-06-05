<?php
namespace app\journal\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use app\journal\model\Journal;

use app\queue\model\SystemQueue;
use think\admin\service\QueueService;

use Symfony\Component\DomCrawler\Crawler;
use League\CommonMark\CommonMarkConverter;
use util\Http;

/**
 * 内容控制器
 * @package app\cms\admin
 */
class Index extends Admin
{
	static $headers = [
		'token'            => 'nh5X3R2idIove869MkxiFQYmxuRaOE8RsDnacLH0',
		':authority'       => 'www.yuque.com',
		':method'          => 'GET',
		':path'            => '/ruanyf/weekly',
		':scheme'          => 'https',
		'referer'          => 'https://www.yuque.com/ruanyf/weekly/issue-104',
		'sec-ch-ua'        => 'Chromium";v="85", "\\Not;A\"Brand";v="99", "Microsoft Edge";v="85',
		'sec-ch-ua-mobile' => '?0',
		'sec-fetch-dest'   => 'document',
		'sec-fetch-mode'   => 'navigate',
		'sec-fetch-site'   => 'same-origin',
		'sec-fetch-user'   => '?1',
	];

	public function index(){
		$map       = $this->getMap();
		$data_list = Journal::select();
		return ZBuilder::make('table')
			->setPageTitle('期刊列表')
			->setTableName('journal', 1)
			->addColumns([ // 批量添加列
				['id',           'ID'],
				['title',        '任务标题'],
				['type',         '类型'],
				['url',          'URL','text.edit'],
				['cover',        '封面', 'picture'],
				['total', 		 '总期数'],
				['sync_time',    '同步时间'],
				['create_time',  '创建时间'],
				['update_time',  '更新时间'],
				['status', '状态', 'switch'],
				['right_button', '操作', 'btn']
			])
			->addTopButtons('add,delete')// 批量添加顶部按钮
			->addTopButton('start', [
				'href'  => url('start'),
				'title' => '开启同步',
				'class' => 'btn btn-primary ajax-get',
			])
			->addTopButton('stop', [
				'href'  => url('stop'),
				'title' => '停止同步',
				'class' => 'btn btn-danger ajax-get',
			])
			->addRightButtons('edit,delete')// 批量添加右侧按钮
			->setRowList($data_list)// 设置表格数据
			->fetch();
	}

	public function add($check = 0){
		if($this->request->isPost()){
			$post = $this->request->post();
			// 检测列表
			if($check){
				$rule     = $post['rule'];
				$response = Http::get($post['url'], [], [
					'headers' => self::$headers
				]);
				if($response){
					// halt($response);
					$crawler = new Crawler($response);
					$list    = $crawler->filter($rule['list_selector'])->each(function ($node, $i) use ($post) {
						$link = self::absoluteUrl($post['url'], $node->attr('href'));
						if(isset($post['rule']['list_href_replace']) && $post['rule']['list_href_replace']){
							$list_href_replace = $post['rule']['list_href_replace'];
							$link = str_ireplace($list_href_replace, '', $link);
						}
						return ['title' => $node->text(), 'link'=>$link];
					});
					// halt($list);
					if($list){
						$first = $list[0];
						// dump($first);
						$content = Http::get($first['link']);
						// halt($content);
						if($content){
							if(isset($rule['content_selector']) && $rule['content_selector']){
								$crawler = new Crawler($content);
								$content = $crawler->filter($rule['content_selector'])->eq(0)->outerHtml();
							}
							if(isset($rule['content_md']) && $rule['content_md']){
								$converter = new CommonMarkConverter([
									'html_input'         => 'strip',
									'allow_unsafe_links' => false,
								]);

								$content = $converter->convertToHtml($content);
							}
						}
						$title = $first['title'];
					}else{
						$title   = '无法获取列表';
						$content = '';
					}
					return ZBuilder::make('form')
						->setPageTitle($title == '无法获取列表'?: '某篇：'.$title)
						// ->setTabNav($list_tab,  'tab1')
						->addFormItems([ // 批量添加数据列
							['richtext', 'content',         '目录'],
						])
						->setFormData([
							'title'   => $title,
							'content' => $content?:'无法获取正文内容',
						]) // 设置表格数据
						->hideBtn('submit')
						->fetch(); // 渲染模板
				}else{
					$this->error("源地址:{$post['url']}打不开");
				}
			}else{
				Journal::create($post);
				$this->success('创建成功', url('index'));
			}
		}
		return ZBuilder::make('form')
			// ->setPageTips('如果出现无法添加的情况，可能由于浏览器将本页面当成了广告，请尝试关闭浏览器的广告过滤功能再试。', 'warning')
			->addFormItems([
				['text',   'title', '名称', ''],
				['text',   'url', '源地址'],
				['image',  'cover', '封面'],
				['select', 'type', '类型', '', ['url'=>'url', 'rss'=>'rss'], 'url'],
				['text',   'rule[list_selector]', '规则-列表选择器'],
				['text',   'rule[list_href_replace]', '规则-列表地址过滤'],
				['text',   'rule[content_selector]', '规则-内容选择器'],
				['radio',  'rule[content_md]', '是否是markdown', '', ['否', '是'], 0],
		   
			])
			->fetch();
	}

	public function edit($id = ''){
		if($this->request->isPost()){
			$post = $this->request->post();
			// halt($post);
			extract($post);
			// 检测列表
			$response = Http::get($post['url'], [], [
				'headers' => self::$headers
			]);
			if($response){
				$crawler = new Crawler($response);
				$list    = $crawler->filter($rule['list_selector'])->each(function ($node, $i) use ($post) {
					$link = self::absoluteUrl($post['url'], $node->attr('href'));
					if(isset($post['rule']['list_href_replace']) && $post['rule']['list_href_replace']){
						$list_href_replace = $post['rule']['list_href_replace'];
						$link = str_ireplace($list_href_replace, '', $link);
					}
					return ['title' => $node->text(), 'link'=>$link];
				});
				// halt($list);
				trace($list);
				if($list){
					$first = $list[0];
					// dump($first);
					$content = Http::get($first['link']);
					trace($content);
					// halt($content);
					if($content){
						$crawler = new Crawler($content);
						try {
							$content = $crawler->filter($rule['content_selector'])->eq(0)->outerHtml();
							if(isset($rule['content_md']) && $rule['content_md']){
								$converter = new CommonMarkConverter([
									'html_input'         => 'strip',
									'allow_unsafe_links' => false,
								]);
								$content = $converter->convertToHtml($content);
							}
						} catch (\Exception $e) {
							$this->error("{$first['link']}<br>提取正文规则{$rule['content_selector']}出错：<br>".short_exception($e));
						}
					}else{
						$this->error("获取列表第一章节{$first['title']}-{$first['link']}内容失败");
					}
				}else{
					$this->error('无法获取列表');
				}
			}else{
				$this->error("源地址:{$post['url']}打不开");
			}
			$post['rule'] = json_encode($rule, JSON_UNESCAPED_UNICODE);
			unset($post['token'], $post['id']);
			Journal::where('id', $id)->update($post);
			$this->success('更新成功');
		}
		$info                            = Journal::find($id);
		$info['rule[list_selector]']     = $info['rule']['list_selector'];
		$info['rule[list_href_replace]'] = $info['rule']['list_href_replace']??'';
		$info['rule[content_selector]']  = $info['rule']['content_selector'];
		$info['rule[content_md]']        = $info['rule']['content_md']??0;

		return ZBuilder::make('form')
			// ->setPageTips('如果出现无法添加的情况，可能由于浏览器将本页面当成了广告，请尝试关闭浏览器的广告过滤功能再试。', 'warning')
			->addFormItems([
				['hidden', 'id'],
				['text',   'title', '名称'],
				['text',   'url', '源地址'],
				['image',  'cover', '封面'],
				['select', 'type', '类型', '', ['url'=>'url', 'rss'=>'rss'], 'url'],
				['static', 'total', '总数'],
				['static', 'sync_time', '最后同步时间'],
				['text',   'rule[list_selector]', '规则-列表选择器'],
				['text',   'rule[list_href_replace]', '规则-列表地址过滤'],
				['text',   'rule[content_selector]', '规则-内容选择器'],
				['radio',  'rule[content_md]', '是否是markdown', '', ['否', '是'], 0],
				['radio',  'status', '启用', '', ['否', '是'], 0],
			])
			->setFormData($info)
			->fetch();
	}

	// 开启同步
	public function start(){
		$message = app()->console->call('xadmin:queue', ['status'])->fetch();
		if(stripos($message, 'not running') !== false){
			$this->error('队列尚未启用，请手动开启');
		}
		try {
			$current    = SystemQueue::where('title', '期刊定时采集')->find();
			$loops_time = 7200;
			if(!$current){
				QueueService::instance()->register('期刊定时采集', '\app\journal\home\Cron', 3, [], 0, $loops_time);
			}else{
				if(!in_array($current['status'], [1,2])){
					$current->status     = 1;
					$current->loops_time = $loops_time;
					$current->save();
				}
			}
		} catch (HttpResponseException $exception) {
			throw $exception;
		} catch (\Exception $exception) {
			$this->error($exception->getMessage());
		}
		$this->success('添加轮询成功');
	}

	// 停止同步
	public function stop(){
		$current = SystemQueue::where('title', '期刊定时采集')->find();
		if($current){
			$current->status    = 4;
			$current->exec_desc = '手动停止';
			$current->save();
		}
		$this->success('停止监听成功');
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
