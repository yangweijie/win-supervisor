<?php
namespace app\journal\home;

use think\admin\Service\QueueService;
use app\journal\model\Journal;
use app\journal\model\JournalContent;
use app\admin\model\Attachment;
use Symfony\Component\DomCrawler\Crawler;


use Jaeger\GHttp;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

use League\CommonMark\CommonMarkConverter;

use util\Http;

class CronDownPic extends QueueService
{

	static $ua  = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4168.0 Safari/537.36 Edg/85.0.548.0';

	public function execute(array $data = [])
	{
		$journal_ids = Journal::where('url', 'like', '%journal/index/yuque_list')->column('id');
		if($journal_ids){
			try {
				$total = count($journal_ids);
				$done  = 0;
				foreach ($journal_ids as $key => $journal_id) {
					$to_sync = JournalContent::where('journal_id', $journal_id)->where('downloaded_pic', 0)->field('id,content,journal_id,downloaded_pic')->select();
					$this->progress(2, "期刊{$journal_id} 有".count($to_sync).'个待同步');
					foreach ($to_sync as $key => $info) {
						$urls   = JournalContent::check_content_pics($info);
						$search = $replace = [];
						$error  = [];
						$target_dir = sys_get_temp_dir();
						if($urls){
							$info->downloaded_pic = 1;
							$info->save();
							try {
								GHttp::multiRequest($urls)
									->withOptions([
										'force_ip_resolve' => 'v4',
										'verify'           => false,
										'headers'          => [
											'User-Agent' => self::$ua,
											"X-Auth-Token: nh5X3R2idIove869MkxiFQYmxuRaOE8RsDnacLH0",
											"Cookie: lang=zh-cn"
										],
										'allow_redirects' => true,
										'timeout'         => 30,
									])->concurrency(random_int(20, 200))->success(function(Response $response, $index) use($urls, $target_dir, &$search, &$replace, &$error){
									// trace('in');
									$content  = (String) $response->getBody();
									$src      = $urls[$index];
									$ext      = '.'.\pathinfo($src, PATHINFO_EXTENSION);
									if($ext == '.'){
										$ext = '.'.\pathinfo(strstr($src, '?x-oss-process',true), PATHINFO_EXTENSION);
									}
									$path     = tempnam($target_dir, 'yuque_').$ext;
									trace($src);
									trace($path);
									file_put_contents($path, $content);
									$ret = self::remote_upload($path, $dir = 'images', $header = [], $remoteurl = $src);
									trace($ret);
									if($ret['code'] == 1){
										$search[$index] = $src;
										$replace[$index] = $ret['path'];
									}else{
										$error[] = "{$src}的图片下载失败：{$ret['info']}";
									}
								})->error(function(RequestException $reason, $index) use ($urls, &$error){
									$reason_json = json_encode($reason, JSON_UNESCAPED_UNICODE);
									ptrace("{$urls[$index]}的内容获取失败：{$reason_json}");
									// dump("{$urls[$index]}的内容获取失败：{$reason_json}");
									$error[] = "{$urls[$index]}的内容获取失败：{$reason_json}";
								})->get();
								$info->content        = str_ireplace($search, $replace, $info['content']);
								if(empty($error)){
									$info->downloaded_pic = 2;
								}else{
									$info->downloaded_pic = 0;
									trace($error);
								}
							} catch (\Exception $e) {
								ptrace($e->getMessage() . PHP_EOL . $e->getTraceAsString());
								dump($e->getMessage() . PHP_EOL . $e->getTraceAsString());
								trace($e->getMessage() . PHP_EOL . $e->getTraceAsString());
								$info->downloaded_pic = 0;
							}
						}else{
							$info->downloaded_pic = 2;
						}
						$info->update_time = datetime();
						$info->save();
					}
					$string  = str_pad(++$done, strlen((string)$total), '0', STR_PAD_LEFT);
					$message = "({$string}/{$total}) -> $done";
					$this->progress(2, $message, $done * 100 / $total);
				}
			} catch (\Exception $e) {
				ptrace(short_exception($e));
				$this->progress(2, short_exception($e));
				$this->progress(4, $e->getMessage());
			}
		}else{
			return "没有需要同步的。";
		}
	}

	// 远程上传
    public static function remote_upload($temp, $dir = 'images', $header = [], $remoteurl = ''){
        $formname = 'file';
        $param = [
            'dir'    => $dir,
        ];
        if(\stripos($temp, 'http') !== false){
        	$tmp = tempnam(sys_get_temp_dir(), 'http_');
        	file_put_contents($tmp, file_get_contents($temp));
        	$md5 = \md5_file($tmp);
        	$ext = pathinfo($temp, PATHINFO_EXTENSION);
        	if(\stripos($ext, '?')!== false){
        		$ext = strstr($ext, '?', true);
        	}
        	$local = config('app.upload_path') .DIRECTORY_SEPARATOR . 'temp'.DIRECTORY_SEPARATOR."{$md5}.{$ext}";
        	\file_put_contents($local, \file_get_contents($temp));
			$remoteurl = $temp;
        	$temp = $local;
        }
        $url = url('journal/index/upload', $param, false, 'yangweijie.cn');
        $url = str_ireplace('https://', 'http://', $url);
        trace($url);
        // curl
        if (version_compare(phpversion(), '5.5.0') >= 0 && class_exists('CURLFile')) {
            $post_data = array(
                $formname => new \CURLFile(realpath($temp)),
				'url'=>$remoteurl,
            );
        } else {
            $post_data = array(
                $formname => '@' . realpath($temp),
				'url'=>$remoteurl,
            );
        }
        // ptrace($post_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($header) {
            trace($header);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $result = curl_exec($ch);
        trace($result);
        // ptrace($result);
        $ret_arr = json_decode($result, true);
        if(false === $ret_arr || null == $ret_arr){
			return [
				'code'=>0,
				'info'=>'服务器没响应:'.curl_error($ch),
			];
        }

        // 'code'  => 1 ,
        // 'info'  => '上传成功' ,
        // 'class' => 'success' ,
        // 'id'    => $file_add['id'],
        // 'path'  => $file_path
        // alert2(curl_errno($ch));
        // alert2(curl_error($ch));
        // alert2($result);
        curl_close($ch);
        return $ret_arr;
    }
}
