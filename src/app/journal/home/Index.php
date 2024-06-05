<?php

namespace app\journal\home;

use app\common\controller\Common;
use app\common\builder\ZBuilder;
use app\admin\model\Attachment as AttachmentModel;
use app\journal\model\Journal;
use app\journal\model\JournalContent;
use util\Http;

use Jaeger\GHttp;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

use Symfony\Component\DomCrawler\Crawler;
use think\Image;

class Index extends Common
{

	static $ua  = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36';

	public function index($group = 1){
		$list     = Journal::select()->toArray();
		$list_tab = [];
		foreach ($list as $value) {
			$list_tab[$value['id']] = ['title'=>$value['title'], 'url'=>url('index', ['group'=>$value['id']])];
		}
		$data_list = JournalContent::where('journal_id', $group)->order('sort DESC')->select();
		return ZBuilder::make('table')
			->setTabNav($list_tab,  'tab1')
			->hideCheckbox(true)
			->assign('system_color', config('app.system_color'))
			->assign('_pop', 1)
			->addTopButton('contribute', ['title'=>'投稿', 'href'=>url('contribute'), 'class'=>'btn btn-primary one-pan-link-mark'], ['area' => ['800px', '62%']])
			->addColumns([ // 批量添加数据列
				// ['id',           'ID'],
				['title',         '目录', 'link', url('detail', ['id'=>'__id__', '_pop'=>1])],
				// ['right_button', '操作', 'btn'],
			])
			->setRowList($data_list) // 设置表格数据
			->fetch(); // 渲染模板
	}

	// 文章详情
	public function detail($id){
		$data = JournalContent::find($id);
		$css = <<<CSSS
<style>
li.item {
	width: 100% !important;
	text-align: left !important;
}
</style>
CSSS;
		$js = <<<JS
<script>
$(function(){
	$('#close-pop').hide();
})
</script>
JS;
		$pics = JournalContent::check_content_pics($data);
		trace($pics);
		if($pics){
			JournalContent::where('id', $id)->update([
				'downloaded_pic' => 0,
			]);
			$this->error("正文图片同步中...");
		}
		return ZBuilder::make('form')
			->setPageTitle($data['title'])
			// ->setTabNav($list_tab,  'tab1')
			->assign('system_color', config('app.system_color'))
			->assign('_admin_base_layout', config('app.admin_base_layout'))
			->assign('_pop', 1)
			->assign('_layout', [])
			->addFormItems([ // 批量添加数据列
				['richtext', 'content',         '目录'],
				//         ['right_button', '操作', 'btn'],
			])
			->setFormData($data) // 设置表格数据
			->hideBtn('submit')
			->setExtraCss($css)
			->setExtraJs($js)
			->addBtn('<button class="btn btn-default" type="button" onclick="javascript:history.back(-1);return false;">返回</button>')
			->fetch(); // 渲染模板
	}

	public function contribute($title='', $url='', $type='', $list_selector='', $content_selector=''){
		if($this->request->isPost()){
			if(empty($title) || empty($url) || empty($type)){
				$this->error('必填参数缺失');
			}
			if(!defined('UID'))	define('UID', 1);
			$post = $this->request->post();
			unset($post['__token__']);
			dp_send_message('期刊投稿', json_encode_pretty($post), 1);
			$this->success('投稿成功，请等待管理员添加', null, '_parent_reload');
		}
		return ZBuilder::make('form')
			->assign('system_color', config('app.system_color'))
			->assign('_pop', 1)
			->assign('_layout', [])
			->addFormItems([
				['text',   'title', '名称(*)', ''],
				['text',   'url', '源地址(*)'],
				['select', 'type', '类型', '', ['url'=>'url'], 'url'],
				['text',   'list_selector', '规则-列表选择器 (css selector)'],
				['text',   'content_selector', '规则-内容选择器 (css selector)'],
			])
			->fetch();
	}

	public function get_yuque_namespaces($key){
		$namespaces = [
			'ruanyifeng' => 'ruanyf/weekly'
		];
		return $namespaces[$key];
	}

	public function yuque_list($key = 'ruanyifeng'){
		$curl = curl_init();
		$namespace = $this->get_yuque_namespaces($key);
		curl_setopt_array($curl, array(
		  CURLOPT_URL            => "https://www.yuque.com/api/v2/repos/{$namespace}/docs",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING       => "",
		  CURLOPT_MAXREDIRS      => 10,
		  CURLOPT_TIMEOUT        => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST  => "GET",
		  CURLOPT_HTTPHEADER     => array(
			"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4168.0 Safari/537.36 Edg/85.0.548.0",
			"X-Auth-Token: nh5X3R2idIove869MkxiFQYmxuRaOE8RsDnacLH0",
			"Cookie: lang=zh-cn"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		if($response && is_string($response)){
			$ret = json_decode($response, 1);
			$data_list     = $ret['data'];
		}else{
			$data_list     = [];
		}
		return ZBuilder::make('table')
			->hideCheckbox(true)
			->assign('system_color', config('app.system_color'))
			->assign('_pop', 1)
			->addColumns([ // 批量添加数据列
				// ['id',           'ID'],
				['title',         '目录', 'link', url('yuque_detail', ['id'=>'__slug__', 'key'=>$key, '_pop'=>1], false, true)],
				// ['right_button', '操作', 'btn'],
			])
			->setRowList($data_list) // 设置表格数据
			->fetch(); // 渲染模板
	}

	// 文章详情
	public function yuque_detail($id, $key){
		$namespace = $this->get_yuque_namespaces($key);
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL            => "https://www.yuque.com/api/v2/repos/{$namespace}/docs/{$id}",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING       => "",
		  CURLOPT_MAXREDIRS      => 10,
		  CURLOPT_TIMEOUT        => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST  => "GET",
		  CURLOPT_HTTPHEADER     => array(
			"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4168.0 Safari/537.36 Edg/85.0.548.0",
			"X-Auth-Token: nh5X3R2idIove869MkxiFQYmxuRaOE8RsDnacLH0",
			"Cookie: lang=zh-cn"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		if($response && is_string($response)){
			$ret  = json_decode($response, 1);
			$data = $ret['data'];
		}else{
			return '';
		}
		$js   = <<<JS
<script>
$(function(){
	$('#close-pop').hide();
})
</script>
JS;
		return ZBuilder::make('form')
			->setPageTitle($data['title'])
			// ->setTabNav($list_tab,  'tab1')
			->assign('system_color', config('app.system_color'))
			->assign('_admin_base_layout', config('app.admin_base_layout'))
			->assign('_pop', 1)
			->assign('_layout', [])
			->addFormItems([ // 批量添加数据列
				['richtext', 'body_html',         '正文'],
				//         ['right_button', '操作', 'btn'],
			])
			->setFormData($data) // 设置表格数据
			->hideBtn('submit')
			->setExtraJs($js)
			->addBtn('<button class="btn btn-default" type="button" onclick="javascript:history.back(-1);return false;">返回</button>')
			->fetch(); // 渲染模板
	}

	public function test_replace(){

		$import = new \app\journal\home\Cron(app());
		return $import->execute();

		// $content = file_get_contents('http://yangweijie.cn/index.php/journal/index/yuque_list');
		$content = Http::get('http://yangweijie.cn/index.php/journal/index/yuque_list');
		halt($content);
		$div = file_get_contents(__DIR__.'/../content.html');
		// dump($doc);
		$crawler = new Crawler($div);
		$list    = $crawler->filter('img')->each(function ($node, $i) use ($div) {
			return $node->attr('src');
		});
		// file_put_contents('1.jpg', file_get_contents('https://cdn.nlark.com/yuque/0/2020/jpeg/84141/1590109787744-70fb1971-5e97-49b1-a0b7-8c8b2d282f0a.jpeg'));
		halt($list);
	}

	public function multi_down(){
		$div     = file_get_contents(__DIR__.'/../content.html');
		$crawler = new Crawler($div);
		$target_dir = 'uploads/files/'.date('Ymd');
		if(!is_dir($target_dir)){
			mkdir($target_dir);
		}
		$list    = $crawler->filter('img')->each(function ($node, $i) {
			$src = $node->attr('src');
			if(stripos($src, '#') !== false){
				$src = strstr($src, '#', true);
			}
			return $src;
		});
		debug('begin');
		if($list){
			// foreach ($list as $src){
			// 	$target = $target_dir . DIRECTORY_SEPARATOR.md5((string) microtime(true)).'.'.pathinfo($src, PATHINFO_EXTENSION);
			// 	file_put_contents($target, file_get_contents($src));
			// }
			try {
				$urls = $list;
				GHttp::multiRequest($urls)
					->withOptions([
						'force_ip_resolve' => 'v4',
						'verify'           => false,
						'headers'          => [
							'User-Agent' => self::$ua,
						],
						'allow_redirects' => true,
						'timeout'         => 30,
					])->concurrency(random_int(20, 200))->success(function(Response $response, $index) use($urls, $target_dir){
					// trace('in');
					$content = (String) $response->getBody();
					$target  = $target_dir . DIRECTORY_SEPARATOR.md5((string) microtime(true)).'.'.pathinfo($urls[$index], PATHINFO_EXTENSION);
					dump([$urls[$index], $target]);
					file_put_contents($target, $content);

				})->error(function(RequestException $reason, $index) use ($urls){
					ptrace("{$urls[$index]}的内容获取失败：{$reason}");
					dump("{$urls[$index]}的内容获取失败：{$reason}");
				})->get();
			} catch (\Exception $e) {
				ptrace($e->getMessage() . PHP_EOL . $e->getTraceAsString());
				dump($e->getMessage() . PHP_EOL . $e->getTraceAsString());
			}
		}
		debug('end');
		return sprintf('%d张图片下载花费 %s 秒', count($list), debug('begin', 'end'));
	}

	// 上传文件
	public function upload($dir = 'file', $from = 'web', $module = 'journal'){
		$url = input('param.url');
		trace(input('param.'));
		// 附件大小限制
        $size_limit = $dir == 'images' ? config('app.upload_image_size') : config('app.upload_file_size');
        $size_limit = $size_limit * 1024;
        // 附件类型限制
        $ext_limit = $dir == 'images' ? config('app.upload_image_ext') : config('app.upload_file_ext');
        $ext_limit = $ext_limit != '' ? parse_attr($ext_limit) : '';
        // 缩略图参数
        $thumb = $this->request->post('thumb', '');
        // 水印参数
        $watermark = $this->request->post('watermark', '');

        // 获取附件数据
        $callback = '';
		$file_input_name = 'file';
        $file = $this->request->file($file_input_name);
        $file_exists = AttachmentModel::where(['md5' => $file->hash('md5')])->order('id DESC')->find();
		trace(is_file($file_exists['path']));
        // 判断附件是否已存在
        if ($file_exists && is_file($file_exists['path'])) {
            if ($file_exists['driver'] == 'local') {
                $file_path = PUBLIC_PATH. $file_exists['path'];
            } else {
                $file_path = $file_exists['path'];
            }
			if($url){
				$file_exists->url = $url;
				$file_exists->save();
			}
			AttachmentModel::where('md5', $file_exists['md5'])->where('id', '<>', $file_exists['id'])->delete();
			return json([
				'code'   => 1,
				'info'   => '上传成功',
				'class'  => 'success',
				'id'     => $file_exists['id'],
				'path'   => $file_path
			]);
        }

        // 判断附件大小是否超过限制
        if ($size_limit > 0 && ($file->getInfo('size') > $size_limit)) {
			return json([
				'code'   => 0,
				'class'  => 'danger',
				'info'   => '附件过大'
			]);
        }
        // 判断附件格式是否符合
        $file_name = $file->getOriginalName();
        $file_ext  = strtolower(substr($file_name, strrpos($file_name, '.')+1));
        $error_msg = '';
        if ($ext_limit == '') {
            $error_msg = '获取文件信息失败！';
        }
        if ($file->getOriginalMime() == 'text/x-php' || $file->getOriginalMime() == 'text/html') {
            $error_msg = '禁止上传非法文件！';
        }
        if (preg_grep("/php/i", $ext_limit)) {
            $error_msg = '禁止上传非法文件！';
        }
        if (!preg_grep("/$file_ext/i", $ext_limit)) {
            $error_msg = '附件类型不正确！';
        }

        if ($error_msg != '') {
			return json([
				'code'   => 0,
				'class'  => 'danger',
				'info'   => $error_msg
			]);
        }

        // 附件上传钩子，用于第三方文件上传扩展
        if (config('app.upload_driver') != 'local') {
            $hook_result = hook('upload_attachment', ['file' => $file, 'from' => $from, 'module' => $module], true);
            if (false !== $hook_result) {
                return $hook_result;
            }
        }

        // 移动到框架应用根目录/uploads/ 目录下
        $info = \think\facade\Filesystem::disk('public')->putFile($dir, $file);
        $info = 'uploads/'.$info;
        if($info){
            // 缩略图路径
            $thumb_path_name = '';
            // 图片宽度
            $img_width = '';
            // 图片高度
            $img_height = '';
            if ($dir == 'images') {
                $img = Image::open($info);
                $img_width  = $img->width();
                $img_height = $img->height();
                // 水印功能
                if ($watermark == '') {
                    if (config('app.upload_thumb_water') == 1 && config('upload_thumb_water_pic') > 0) {
                        $this->create_water($info, config('upload_thumb_water_pic'));
                    }
                } else {
                    if (strtolower($watermark) != 'close') {
                        list($watermark_img, $watermark_pos, $watermark_alpha) = explode('|', $watermark);
                        $this->create_water($info, $watermark_img, $watermark_pos, $watermark_alpha);
                    }
                }

                // 生成缩略图
                if ($thumb == '') {
                    if (config('app.upload_image_thumb') != '') {
                        $thumb_path_name = $this->create_thumb($info, pathinfo($info, PATHINFO_DIRNAME), pathinfo($info, PATHINFO_BASENAME));
                    }
                } else {
                    if (strtolower($thumb) != 'close') {
                        list($thumb_size, $thumb_type) = explode('|', $thumb);
                        $thumb_path_name = $this->create_thumb($info, pathinfo($info, PATHINFO_DIRNAME), pathinfo($info, PATHINFO_BASENAME));
                    }
                }
            }

            // 获取附件信息
            $file_info = [
                'uid'    => 1,
                'name'   => $file_name,
                'mime'   => $file->getMime(),
                'path'   => str_replace('\\', '/', $info),
                'ext'    => $file->extension(),
                'size'   => $file->getSize(),
                'md5'    => $file->md5(),
                'sha1'   => $file->sha1(),
                'thumb'  => $thumb_path_name,
                'module' => $module,
                'width'  => $img_width,
                'height' => $img_height,
				'url'    => $url,
            ];

            // 写入数据库
            if ($file_add = AttachmentModel::create($file_info)) {
				AttachmentModel::where('md5', $file_info['md5'])->where('id', '<>', $file_add['id'])->delete();
                $file_path = PUBLIC_PATH. $file_info['path'];
					return json([
						'code'   => 1,
						'info'   => '上传成功',
						'class'  => 'success',
						'id'     => $file_add['id'],
						'path'   => $file_path
					]);
            } else {
				return json(['code' => 0, 'class' => 'danger', 'info' => '上传失败']);
            }
        }else{
			return json(['code' => 0, 'class' => 'danger', 'info' => $file->getError()]);
        }
	}

}