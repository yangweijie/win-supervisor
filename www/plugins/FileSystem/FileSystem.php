<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace plugins\FileSystem;


use app\common\controller\Plugin;
use app\admin\model\Attachment as AttachmentModel;
use think\facade\Cache;
use think\facade\Db;
use think\facade\Env;

/**
 * 上传插件
 * @package plugins\FileSystem
 * @author 蔡伟明 <314013107@qq.com>
 */
class FileSystem extends Plugin
{
	/**
	 * @var array 插件信息
	 */
	public $info = [
		// 插件名[必填]
		'name'        => 'FileSystem',
		// 插件标题[必填]
		'title'       => 'FileSystem常见对象存储',
		// 插件唯一标识[必填],格式：插件名.开发者标识.plugin
		'identifier'  => 'file_system.dragonlhp.plugin',
		// 插件图标[选填]
		'icon'        => 'fa fa-fw fa-upload',
		// 插件描述[选填]
		'description' => '集合国内常用的对象存储,启用此插件后将对config/filesystem.php配置文件失效!卸载后自动恢复!',
		// 插件作者[必填]
		'author'      => '李世平',
		// 作者主页[选填]
		'author_url'  => 'https://www.thinkphp.cn/ext/71',
		// 插件版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
		'version'     => '1.1.0',
		// 是否有后台管理功能[选填]
		'admin'       => '0',
	];

	/**
	 * @var array 插件钩子
	 */
	public $hooks = [
		'upload_attachment',
		'save_plugin_config'
	];

	private $app_options = [
		'oss' => '阿里云OSS',
		'cos' => '腾讯COS',
		'qiniu' => '七牛云',
		'sftp' => 'sftp',
		'ftp' => 'ftp',
	];
	function savePluginConfig($configs)
	{
		$data = [];
		$configs = json_decode($configs, true);
		foreach ($configs as $config_key => $config) {
			$array = [];
			$keys = explode('_', $config_key);
			$lastKey = array_pop($keys);
			$currentArray = &$array;

			foreach ($keys as $key) {
				$currentArray[$key] = [];
				$currentArray = &$currentArray[$key];
			}

			$currentArray[$lastKey] = $config;
			$data = array_merge_recursive($data, $array);
		}

		$data['cos']['connect_timeout'] = $data['cos']['connect']['timeout'];
		$data['cos']['read_from_cdn'] = $data['cos']['read']['from']['cdn'];
		unset($data['cos']['connect']);
		unset($data['cos']['read']);

		$upload_driver = Db::name('admin_config')->where(['name' => 'upload_driver', 'group' => 'upload'])->find();

		Cache::set('filesystem_config', [
			// 默认磁盘
			'default' => $upload_driver['value'],
			// 磁盘列表
			'disks'   => $data
		]);
		return true;
	}
	function uploadAttachment()
	{
	}
	/**
	 * 安装方法
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return bool
	 */
	public function install()
	{
		if (!version_compare(config('dolphin.product_version'), '1.0.6', '>=')) {
			$this->error = '本插件仅支持DolphinPHP1.0.6或以上版本';
			return false;
		}
		$upload_driver = Db::name('admin_config')->where(['name' => 'upload_driver', 'group' => 'upload'])->find();
		if (!$upload_driver) {
			$this->error = '未找到【上传驱动】配置,请确认DolphinPHP版本是否为1.0.6以上';
			return false;
		}
		$options = parse_attr($upload_driver['options']);
		foreach ($options as $key => $option) {
			if (isset($this->app_options[$key])) {
				unset($this->app_options[$key]);
			}
		}

		if ($this->app_options) {
			$upload_driver['options'] = implode_attr(array_merge($options, $this->app_options));;


			$result = Db::name('admin_config')
				->where(['name' => 'upload_driver', 'group' => 'upload'])
				->update(['options' => (string)$upload_driver['options']]);

			if (false === $result) {
				$this->error = '上传驱动设置失败';
				return false;
			}
		}
		return true;
	}

	/**
	 * 卸载方法
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return bool
	 */
	public function uninstall()
	{
		$disks = Cache::get('filesystem_config');
		$upload_driver = Db::name('admin_config')->where(['name' => 'upload_driver', 'group' => 'upload'])->find();
		if ($upload_driver) {
			$options = parse_attr($upload_driver['options']);
			foreach ($options as $key => $option) {
				if (isset($this->app_options[$key])) {
					unset($options[$key]);
					unset($disks['disks'][$key]);
				}
			}
			$options = implode_attr($options);
			$result = Db::name('admin_config')
				->where(['name' => 'upload_driver', 'group' => 'upload'])
				->update(['options' => $options, 'value' => 'local']);

			if (false === $result) {
				$this->error = '上传驱动设置失败';
				return false;
			}
		}
		if (count($disks['disks']) == 1) {
			$disks = null;
		}
		Cache::set('filesystem_config', $disks);
		return true;
	}
}
