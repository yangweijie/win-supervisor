<?php

namespace app\journal\model;

use app\admin\model\Attachment;
use think\Model;
use Symfony\Component\DomCrawler\Crawler;

class JournalContent extends Model
{
    protected $name = 'journal_content';

  	// 自动写入时间戳
    protected $autoWriteTimestamp = 'datetime';
    protected $dateFormat         = 'Y-m-d H:i:s';

	// 设置json类型字段
	protected $json = ['rule'];

    // 设置JSON数据返回数组
    protected $jsonAssoc = true;

    public static function check_content_pics($info){
    	$pinfo = Journal::find($info['journal_id']);
    	if(stripos($pinfo['url'], 'journal/index/yuque_list') === false){
    		return [];
    	}
    	$crawler = new Crawler($info['content']);
		$list    = $crawler->filter('img')->each(function ($node, $i) {
			$src = $node->attr('src');
			if(stripos($src, '#') !== false){
				$src = strstr($src, '#', true);
			}
			return $src;
		});
		$urls = [];
		$check_path_prefix = request()->isCli()? realpath('.').DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR:realpath('.').DIRECTORY_SEPARATOR;
		trace('check_path_prefix:'.$check_path_prefix);
		$file_not_exist = [];
		foreach ($list as $src){
			// 本地路径
			if(stripos($src, 'http') === false){
				if(stripos($src, '//') !== false){
					$src = \str_ireplace('//', '', $src);
				}
				if(stripos($src, '/uploads') !== false){
					$src = \str_ireplace('/uploads', 'uploads', $src);
				}
				if(!is_file("{$check_path_prefix}{$src}")){
					$url = Attachment::where('path', $src)->order('id desc')->value('url');
					if($url){
						$urls[] = $url;
						$file_not_exist[] = "{$check_path_prefix}{$src}|{$src}|{$url}";
					}
				}
			}else{
				// 远程路径
				$urls[] = $src;
			}
		}
		trace('urls');
		trace($urls);
		trace($file_not_exist);
		return $urls;
    }
}
