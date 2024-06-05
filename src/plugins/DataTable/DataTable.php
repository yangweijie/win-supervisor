<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace plugins\DataTable;

use app\common\controller\Plugin;
use util\File;

/**
 * Class DataTable
 * @package form\data_table
 */
class DataTable extends Plugin
{

	/**
	 * @var array 插件信息
	 */
	public $info = [
		// 插件名[必填]
		'name'        => 'DataTable',
		// 插件标题[必填]
		'title'       => '数据表格',
		// 插件唯一标识[必填],格式：插件名.开发者标识.plugin
		'identifier'  => 'data_table.dragonlhp.plugin',
		// 插件图标[选填]
		'icon'        => 'fa fa-fw fa-info-circle',
		// 插件描述[选填]
		'description' => '在表单中显示表格，用于自定义数据录入，可编辑。',
		// 插件作者[必填]
		'author'      => '李世平',
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
		'datatable'
	];


	/**
	 * data_table 表单项钩子
	 * @throws \Exception
	 */
	public function datatable($item)
	{

		$items = [
			'css' => [
				$this->getPublicAssetsPath('datatable.css'),
			],
			'js' => [
				$this->getPublicAssetsPath('datatable.js'),
			],
			'item' => $this->item(...$item),
		];

		$items['item']['view'] = dirname(__FILE__) . DIRECTORY_SEPARATOR . strtolower($this->info['name']) . '.html';

		return $items;
	}

	/**
	 * 显示表格
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param array $data 数据
	 * @param bool $default 默认值
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return array
	 */
	public function item($name = '', $title = '', $data = [], $default = [])
	{
		if (!empty($data)) {
			foreach ($data as $key => $row) {
				if (is_array($row)) {
					switch ($row['type']) {
						case 'select':
							$data[$key] =  [
								'type' => 'select',
								'name' => $name . '_' . $key . '_select[]',
								'title' => $row['title'],
								'value' => isset($default[$key]) ? $default[$key] : '',
								'options' => $row['options']

							];
							break;
						default:
					}
				} else {
					$data[$key] =  [
						'type' => 'text',
						'name' =>  $name . '_' . $key . '_text[]',
						'title' => $row,
						'value' => isset($default[$key]) ? $default[$key] : '',
					];
				}
			}
		}

		// dump($data);
		return [
			'name'  => $name,
			'title' => $title,
			'data'  => $data,
		];
	}

	/**
	 * 分析单元格合并
	 * @param $v
	 * @return array
	 * @author 蔡伟明 <314013107@qq.com>
	 */
	private function parseCell($v)
	{
		if (preg_match('/\[(.*)\]/', $v, $matches)) {
			$cell  = str_replace($matches[0], '', $v);
			$merge = explode(':', $matches[1]);
			$result = [
				'value'   => $cell,
				'colspan' => $merge[0],
				'rowspan' => isset($merge[1]) ? $merge[1] : '',
			];
		} else {
			$result = [
				'value'   => $v,
				'rowspan' => '',
				'colspan' => '',
			];
		}

		return $result;
	}



	/**
	 * $file string  资源相对路径
	 */
	private function getPublicAssetsPath($file = '')
	{
		$assets_path =   DIRECTORY_SEPARATOR . 'static' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . strtolower($this->info['name']) . DIRECTORY_SEPARATOR;

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
		// dump($this->getAppAssetsPath(), $this->getPublicAssetsPath());
		// die;
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
		// dump($this->getPublicAssetsPath());
		// die;
		return true;
	}
}
