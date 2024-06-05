<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\demo\home;

use app\BaseController;
use poster\Poster;

/**
 * 前台首页控制器
 * @package app\demo\admin
 */
class Index extends BaseController
{
	/**
	 * 首页
	 * @return mixed
	 */
	public function index()
	{
		# 合成图片
		$url = (new Poster(800, 800))
			->addImg(root_path() . 'runtime/pppp.jpg', [0, 0], [800, 800])
			->addImg(root_path() . 'runtime/sptk1.png', [0, 0], [800, 800])
			->addText('999', 75, [40, 760], [255, 255, 255],)
			->render(root_path() . 'public/image/spt.jpg');
		
		$url =  request()->domain(true) . '/' . str_replace(root_path() . 'public/', '/', $url);
		return "<img src='" . $url . "'>";
	}
	public function left()
	{
		# 合成图片
		$url = (new Poster(800, 800))
			->addImg(root_path() . 'runtime/pppp.jpg', [0, 0], [800, 680])
			->addImg(root_path() . 'runtime/sptk1.png', [0, 0], [800, 800])
			->addText('999', 75, [40, 760], [255, 255, 255],)
			->render(root_path() . 'public/image/spt.jpg');

		$url =  request()->domain(true) . '/' . str_replace(root_path() . 'public/', '/', $url);
		return "<img src='" . $url . "'>";
	}
	public function reight()
	{
		# 合成图片
		$url = (new Poster(800, 800))
			->addImg(root_path() . 'runtime/pppp.jpg', [0, 0], [800, 710])
			->addImg(root_path() . 'runtime/sptk2.png', [0, 0], [800, 800])
			->addText('999', 75, [600, 750], [255, 255, 255],)
			->render(root_path() . 'public/image/spt.jpg');

		$url =  request()->domain(true) . '/' . str_replace(root_path() . 'public/', '/', $url);
		return "<img src='" . $url . "'>";
	}
}
