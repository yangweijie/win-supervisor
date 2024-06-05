<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace plugins\OrgTree;

use app\common\controller\Plugin;
use think\facade\View;
use util\File;

/**
 * Class OrgTree
 * @package form\complex_table
 */
class OrgTree extends Plugin
{
	/**
	 * 添加部门
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $data_url 树形结构数据地址（json格式）
	 * @param string $extra_class 额外css类名
	 * @return array
	 */
	public function item($name = '', $title = '', $tips = '', $default = '', $data_url = '', $extra_class = '')
	{
		return [
			'type'			=> 'orgtree',
			'name'			=> $name,
			'title'			=> $title,
			'tips'			=> $tips,
			'value'			=> is_array($default) ? implode(';', $default) : $default,
			'data_url'		=> $data_url ? $data_url : (string)admin_url(''),
			'extra_class'	=> $extra_class,
		];
	}



	/**
	 * @var array 插件信息
	 */
	public $info = [
		// 插件名[必填]
		'name'        => 'OrgTree',
		// 插件标题[必填]
		'title'       => '树型选择器',
		// 插件唯一标识[必填],格式：插件名.开发者标识.plugin
		'identifier'  => 'org_tree.dragonlhp.plugin',
		// 插件图标[选填]
		'icon'        => 'fa fa-fw fa-info-circle',
		// 插件描述[选填]
		'description' => '在表单中选择部门并以标签方式展示。',
		// 插件作者[必填]
		'author'      => 'dragonlhp',
		// 作者主页[选填]
		'author_url'  => '',
		// 插件版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
		'version'     => '1.0.0',
		// 是否有后台管理功能[选填]
		'admin'       => '0',
	];

	/**
	 * @var array 插件钩子
	 */
	public $hooks = [
		'orgtree'
	];

	/**
	 * data_table 表单项钩子
	 * @throws \Exception
	 */
	public function orgtree($item)
	{

		$items = [
			// 'css' => [
			// 	$this->getPublicAssetsPath('complexTable.css'),
			// ],
			'js' => [
				$this->getPublicAssetsPath('libs/orgTree.js'),
				$this->getPublicAssetsPath('orgtree.js'),
			],
			'item' => $this->item(...$item),
		];
		// View::assign($items['item']);
		$items['item']['view'] = dirname(__FILE__) . DIRECTORY_SEPARATOR . strtolower($this->info['name']) . '.html';

		return $items;
	}


	/**
	 * $file string  资源相对路径
	 */
	private function getPublicAssetsPath($file = '')
	{
		$assets_path =   DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . strtolower($this->info['name']) . DIRECTORY_SEPARATOR;

		if ($file) {
			return   $assets_path . $file;
		} else {
			return root_path() . 'public' . $assets_path;
		}
	}


	private function getAppAssetsPath()
	{
		return  dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
	}


	/**
	 * 安装方法
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return bool
	 */
	public function install()
	{
		// 复制静态资源目录
		File::copy_dir($this->getAppAssetsPath(), $this->getPublicAssetsPath());
		// 删除静态资源目录
		// File::del_dir($this->getAppAssetsPath());

		return true;
	}

	/**
	 * 卸载方法必
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return bool
	 */
	public function uninstall()
	{
		// 复制静态资源目录
		// File::copy_dir($this->getPublicAssetsPath(), $this->getAppAssetsPath());
		// 删除静态资源目录
		File::del_dir($this->getPublicAssetsPath());
		return true;
	}
}
