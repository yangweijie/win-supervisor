<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\model\HookPlugin;
use app\admin\model\Module as ModuleModel;
use app\admin\model\Plugin as PluginModel;
use app\admin\model\Menu as MenuModel;
use app\admin\model\Action as ActionModel;
use think\facade\Cache;
use util\Database;
use util\Sql;
use util\File;
use util\PHPZip;
use util\Tree;
use think\facade\Db;
use think\facade\Event;
use think\facade\Env;
use think\facade\View;

/**
 * 模块管理控制器
 * @package app\admin\controller
 */
class Module extends Admin
{
	/**
	 * 模块首页
	 * @param string $group 分组
	 * @param string $type 显示类型
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function index($group = 'local', $type = '')
	{
		// 配置分组信息
		$list_group = ['local' => '本地模块'];
		$tab_list = [];
		foreach ($list_group as $key => $value) {
			$tab_list[$key]['title'] = $value;
			$tab_list[$key]['url']   = (string)url('index', ['group' => $key]);
		}

		// 监听tab钩子
		Event::trigger('module_index_tab_list', $tab_list);

		switch ($group) {
			case 'local':
				// 查询条件
				$keyword = $this->request->get('keyword', '');

				if (input('?param.status') && input('param.status') != '_all') {
					$status = input('param.status');
				} else {
					$status  = '';
				}

				$ModuleModel = new ModuleModel();
				$result = $ModuleModel->getAll($keyword, $status);

				if ($result['modules'] === false) {
					$this->error($ModuleModel->getError());
				}

				$type_show = Cache::get('module_type_show');
				$type_show = $type != '' ? $type : ($type_show == false ? 'block' : $type_show);
				Cache::set('module_type_show', $type_show);
				$type = $type_show == 'block' ? 'list' : 'block';

				View::assign('page_title', '模块管理');
				View::assign('modules', $result['modules']);
				View::assign('total', $result['total']);
				View::assign('tab_nav', ['tab_list' => $tab_list, 'curr_tab' => $group]);
				View::assign('type', $type);
				return View::fetch();
				break;
			case 'online':
				return '<h2>正在建设中...</h2>';
				break;
			default:
				$this->error('非法操作');
		}
	}

	/**
	 * 安装模块
	 * @param string $name 模块标识
	 * @param int $confirm 是否确认
	 * @author 蔡伟明 <314013107@qq.com>
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function install($name = '', $confirm = 0)
	{
		// 设置最大执行时间和内存大小
		ini_set('max_execution_time', '0');
		ini_set('memory_limit', '1024M');

		if ($name == '') $this->error('模块不存在！');
		if ($name == 'admin' || $name == 'user') $this->error('禁止操作系统核心模块！');

		// 模块配置信息
		$module_info = ModuleModel::getInfoFromFile($name);

		if ($confirm == 0) {
			$need_module = [];
			$need_plugin = [];
			$table_check = [];
			// 检查模块依赖
			if (isset($module_info['need_module']) && !empty($module_info['need_module'])) {
				$need_module = $this->checkDependence('module', $module_info['need_module']);
			}

			// 检查插件依赖
			if (isset($module_info['need_plugin']) && !empty($module_info['need_plugin'])) {
				$need_plugin = $this->checkDependence('plugin', $module_info['need_plugin']);
			}

			// 检查数据表
			if (isset($module_info['tables']) && !empty($module_info['tables'])) {
				foreach ($module_info['tables'] as $table) {
					if (Db::query("SHOW TABLES LIKE '" . config('database.connections')[config('database.default')]['prefix'] . "{$table}'")) {
						$table_check[] = [
							'table' => config('database.connections')[config('database.default')]['prefix'] . "{$table}",
							'result' => '<span class="text-danger">存在同名</span>'
						];
					} else {
						$table_check[] = [
							'table' => config('database.connections')[config('database.default')]['prefix'] . "{$table}",
							'result' => '<i class="fa fa-check text-success"></i>'
						];
					}
				}
			}

			View::assign('need_module', $need_module);
			View::assign('need_plugin', $need_plugin);
			View::assign('table_check', $table_check);
			View::assign('name', $name);
			View::assign('page_title', '安装模块：' . $name);
			return View::fetch();
		}

		// 安装模块插件
		$this->install_plugin($name);

		// 执行安装文件
		$install_file = realpath(root_path() . 'app' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'install.php');
		if (file_exists($install_file)) {
			@include($install_file);
		}

		// 执行安装模块sql文件
		$sql_file = realpath(root_path() . 'app' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'sql/install.sql');
		if (file_exists($sql_file)) {
			if (isset($module_info['database_prefix']) && !empty($module_info['database_prefix'])) {
				$sql_statement = Sql::getSqlFromFile($sql_file, false, [$module_info['database_prefix'] => config('database.connections')[config('database.default')]['prefix']]);
			} else {
				$sql_statement = Sql::getSqlFromFile($sql_file);
			}
			if (!empty($sql_statement)) {
				foreach ($sql_statement as $value) {
					try {
						Db::execute($value);
					} catch (\Exception $e) {
						$this->error('导入SQL失败,请检查install.sql的语句是否正确?');
					}
				}
			}
		}

		// 添加菜单
		$menus = ModuleModel::getMenusFromFile($name);
		if (is_array($menus) && !empty($menus)) {
			if (false === $this->addMenus($menus, $name)) {
				$this->error('菜单添加失败，请重新安装');
			}
		}

		// 检查是否有模块设置信息
		if (isset($module_info['config']) && !empty($module_info['config'])) {
			$module_info['config'] = json_encode(parse_config($module_info['config']));
		}

		// 检查是否有模块授权配置
		if (isset($module_info['access']) && !empty($module_info['access'])) {
			$module_info['access'] = json_encode($module_info['access']);
		}

		// 检查是否有行为规则
		if (isset($module_info['action']) && !empty($module_info['action'])) {
			$ActionModel = new ActionModel;
			if (!$ActionModel->saveAll($module_info['action'])) {
				MenuModel::where('module', $name)->delete();
				$this->error('行为添加失败，请重新安装');
			}
		}

		// 将模块信息写入数据库
		$ModuleModel = new ModuleModel($module_info);
		$allowField = ['name', 'title', 'icon', 'description', 'author', 'author_url', 'config', 'access', 'version', 'identifier', 'status'];

		if ($ModuleModel->allowField($allowField)->save()) {
			$app_asset = root_path() . 'app' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'asset' . DIRECTORY_SEPARATOR;
			$public_asset = root_path() . 'public' . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
			// 复制静态资源目录
			File::copy_dir($app_asset, $public_asset);
			// 删除静态资源目录
			// File::del_dir($app_asset);
			cache('modules', null);
			cache('module_all', null);
			// 记录行为
			action_log('module_install', 'admin_module', 0, session('UID'), $module_info['title']);
			$this->success('模块安装成功', 'index');
		} else {
			MenuModel::where('module', $name)->delete();
			$this->error('模块安装失败');
		}
	}

	/**
	 * 安装注册模块内插件
	 * 模块内插件，解决模块需要执行钩子，但是没有插件的问题
	 * 注意：因为是插件，所以插件不单独设置sql文件，不单独设置配置文件，
	 * 配置文件直接写到插件 config属性中，格式和正常插件一样；
	 * 为了简化功能，模块内插件只做事件注册和事件方法，不关联插件控制器等内容
	 * 
	 * @param string $name 模块名称
	 * @return void
	 */
	private function install_plugin($name)
	{
		$module_plugin_dir =	root_path() . 'app' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'plugins';
		if (!is_dir($module_plugin_dir)) {
			return;
		}
		$module_plugin_files = scandir($module_plugin_dir);
		foreach ($module_plugin_files as $key => $module_plugin_file) {
			$plugin_file = $module_plugin_dir . DIRECTORY_SEPARATOR . $module_plugin_file;
			if (is_file($plugin_file)) {
				$PluginName =	basename($module_plugin_file, '.php');
				$plugin_class = 'app' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . $PluginName;
				if (class_exists($plugin_class)) {
					// 实例化插件
					$plugin = new $plugin_class;
					// 插件预安装
					if (!$plugin->install()) {
						$this->error('模块插件预安装失败!原因：' . $plugin->getError());
					}

					// 添加钩子
					if (isset($plugin->hooks) && !empty($plugin->hooks)) {
						if (!HookPlugin::addHooks($plugin->hooks, $PluginName)) {
							$this->error('模块安装插件钩子时出现错误，请重新安装');
						}
						cache('hook_plugins', null);
					}

					// 插件配置信息
					$plugin_info = $plugin->info;

					// 验证插件信息
					$result = $this->validate($plugin_info, 'Plugin');
					// 验证失败 输出错误信息
					if (true !== $result) $this->error($result);

					// 并入插件配置值
					$plugin_info['config'] = $plugin->config;

					$plugin_info['type'] = 'module';
					$config = $plugin_info;
					unset($config['config']);
					if (!PluginModel::where($config)->find()) {
						// 将插件信息写入数据库
						if (PluginModel::create($plugin_info)) {
							cache('plugin_all', null);
						} else {
							$this->error('模块插件安装失败');
						}
					}
				}
			}
		}
	}

	/**
	 * 
	 * 卸载插件
	 *
	 * @param string
	 * @return void
	 */
	private function	uninstall_plugin($name)
	{
		$module_plugin_dir =	root_path() . 'app' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'plugins';
		if (!is_dir($module_plugin_dir)) {
			return true;
		}
		$module_plugin_files = scandir($module_plugin_dir);
		foreach ($module_plugin_files as $module_plugin_file) {
			$plugin_file = $module_plugin_dir . DIRECTORY_SEPARATOR . $module_plugin_file;
			if (is_file($plugin_file)) {
				$PluginName =	basename($module_plugin_file, '.php');
				$plugin_class = 'app' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . $PluginName;
				if (class_exists($plugin_class)) {
					// 实例化插件
					$plugin = new $plugin_class;
					// 插件预安装
					if (!$plugin->uninstall()) {
						$this->error('模块插件预卸载失败!原因：' . $plugin->getError());
					}

					// 卸载插件自带钩子
					if (isset($plugin->hooks) && !empty($plugin->hooks)) {
						if (false === HookPlugin::deleteHooks($PluginName)) {
							$this->error('模块卸载插件钩子时出现错误，请重新卸载');
						}
						cache('hook_plugins', null);
					}

					// 删除插件信息
					if (PluginModel::where('name', $PluginName)->delete()) {
						cache('plugin_all', null);
					} else {
						$this->error('模块插件卸载失败');
					}
				}
			}
		}
	}



	/**
	 * 卸载模块
	 * @param string $name 模块名
	 * @param int $confirm 是否确认
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function uninstall($name = '', $confirm = 0)
	{
		if ($name == '') $this->error('模块不存在！');
		if ($name == 'admin') $this->error('禁止操作系统模块！');

		// 模块配置信息
		$module_info = ModuleModel::getInfoFromFile($name);

		if ($confirm == 0) {
			View::assign('name', $name);
			View::assign('page_title', '卸载模块：' . $name);
			return View::fetch();
		}

		// 执行卸载文件
		$uninstall_file = realpath(root_path() . 'app/' . $name . '/uninstall.php');
		if (file_exists($uninstall_file)) {
			@include($uninstall_file);
		}

		// 卸载模块插件
		$this->uninstall_plugin($name);

		// 执行卸载模块sql文件
		$clear = $this->request->get('clear');
		if ($clear == 1) {
			$sql_file = realpath(root_path() . 'app/' . $name . '/sql/uninstall.sql');
			if (file_exists($sql_file)) {
				if (isset($module_info['database_prefix']) && !empty($module_info['database_prefix'])) {
					$sql_statement = Sql::getSqlFromFile($sql_file, false, [$module_info['database_prefix'] => config('database.connections')[config('database.default')]['prefix']]);
				} else {
					$sql_statement = Sql::getSqlFromFile($sql_file);
				}

				if (!empty($sql_statement)) {
					foreach ($sql_statement as $sql) {
						try {
							Db::execute($sql);
						} catch (\Exception $e) {
							$this->error('卸载失败，请检查uninstall.sql的语句是否正确');
						}
					}
				}
			}
		}

		// 删除菜单
		if (false === MenuModel::where('module', $name)->delete()) {
			$this->error('菜单删除失败，请重新卸载');
		}

		// 删除授权信息
		if (false === Db::name('admin_access')->where('module', $name)->delete()) {
			$this->error('删除授权信息失败，请重新卸载');
		}

		// 删除行为规则
		if (false === Db::name('admin_action')->where('module', $name)->delete()) {
			$this->error('删除行为信息失败，请重新卸载');
		}

		// 删除模块信息
		if (ModuleModel::where('name', $name)->delete()) {
			$app_asset = root_path() . 'app' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
			$public_asset = root_path() . 'public' . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
			// 复制静态资源目录
			// File::copy_dir($public_asset,$app_asset);
			// 删除静态资源目录
			File::del_dir($public_asset);
			cache('modules', null);
			cache('module_all', null);
			// 记录行为
			action_log('module_uninstall', 'admin_module', 0, session('UID'), $module_info['title']);
			$this->success('模块卸载成功', 'index');
		} else {
			$this->error('模块卸载失败');
		}
	}

	/**
	 * 更新模块配置
	 * @param string $name 模块名
	 * @author 蔡伟明 <314013107@qq.com>
	 */
	public function update($name = '')
	{
		$name == '' && $this->error('缺少模块名！');

		$Module = ModuleModel::where(['name' => $name])->find();
		!$Module && $this->error('模块不存在，或未安装');

		// 模块配置信息
		$module_info = ModuleModel::getInfoFromFile($name);
		unset($module_info['name']);


		// 删除菜单
		if (false === MenuModel::where('module', $name)->delete()) {
			$this->error('菜单删除失败，请重新卸载');
		}
		// 添加菜单
		$menus = ModuleModel::getMenusFromFile($name);
		if (is_array($menus) && !empty($menus)) {
			if (false === $this->addMenus($menus, $name)) {
				$this->error('菜单更新失败，请重新安装');
			}
		}


		// 检查是否有模块设置信息
		if (isset($module_info['config']) && !empty($module_info['config'])) {
			$module_info['config'] = json_encode(parse_config($module_info['config']));
		} else {
			$module_info['config'] = '';
		}

		// 检查是否有模块授权配置
		if (isset($module_info['access']) && !empty($module_info['access'])) {
			$module_info['access'] = json_encode($module_info['access']);
		} else {
			$module_info['access'] = '';
		}

		// 更新模块信息
		if (false !== $Module->save($module_info)) {
			$this->success('模块配置更新成功');
		} else {
			$this->error('模块配置更新失败，请重试');
		}
	}

	/**
	 * 导出模块
	 * @param string $name 模块名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @throws \think\facade\Db\exception\DataNotFoundException
	 * @throws \think\facade\Db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function export($name = '')
	{
		if ($name == '') $this->error('缺少模块名');

		$export_data = $this->request->get('export_data', '');
		if ($export_data == '') {
			View::assign('page_title', '导出模块：' . $name);
			return View::fetch();
		}

		// 模块导出目录
		$module_dir = Env::get('root_path') . 'export/module/' . $name;

		// 删除旧的导出数据
		if (is_dir($module_dir)) {
			File::del_dir($module_dir);
		}

		// 复制模块目录到导出目录
		File::copy_dir(root_path() . 'app/' . $name, $module_dir);
		// 复制静态资源目录
		File::copy_dir(Env::get('root_path') . 'public/static/' . $name, $module_dir . '/public/static/' . $name);

		// 模块本地配置信息
		$module_info = ModuleModel::getInfoFromFile($name);

		// 检查是否有模块设置信息
		if (isset($module_info['config'])) {
			$db_config = ModuleModel::where('name', $name)->value('config');
			$db_config = json_decode($db_config, true);
			// 获取最新的模块设置信息
			$module_info['config'] = set_config_value($module_info['config'], $db_config);
		}

		// 检查是否有模块行为信息
		$action = Db::name('admin_action')->where('module', $name)->field('module,name,title,remark,rule,log,status')->select()->toArray();
		if ($action) {
			$module_info['action'] = $action;
		}

		// 表前缀
		$module_info['database_prefix'] = config('database.connections')[config('database.default')]['prefix'];

		// 生成配置文件
		if (false === $this->buildInfoFile($module_info, $name)) {
			$this->error('模块配置文件创建失败，请重新导出');
		}

		// 获取模型菜单并导出
		$fields = 'id,pid,title,icon,url_type,url_value,url_target,online_hide,sort,status';
		$menus = MenuModel::getMenusByGroup($name, $fields);
		if (false === $this->buildMenuFile($menus, $name)) {
			$this->error('模型菜单文件创建失败，请重新导出');
		}

		// 导出数据库表
		if (isset($module_info['tables']) && !empty($module_info['tables'])) {
			if (!is_dir($module_dir . '/sql')) {
				mkdir($module_dir . '/sql', 644, true);
			}
			if (!Database::export($module_info['tables'], $module_dir . '/sql/install.sql', config('database.connections')[config('database.default')]['prefix'], $export_data)) {
				$this->error('数据库文件创建失败，请重新导出');
			}
			if (!Database::exportUninstall($module_info['tables'], $module_dir . '/sql/uninstall.sql', config('database.connections')[config('database.default')]['prefix'])) {
				$this->error('数据库文件创建失败，请重新导出');
			}
		}

		// 记录行为
		action_log('module_export', 'admin_module', 0, session('UID'), $module_info['title']);

		// 打包下载
		$archive = new PHPZip;
		return $archive->ZipAndDownload($module_dir, $name);
	}

	/**
	 * 创建模块菜单文件
	 * @param array $menus 菜单
	 * @param string $name 模块名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return int
	 */
	private function buildMenuFile($menus = [], $name = '')
	{
		$menus = Tree::toLayer($menus);

		// 美化数组格式
		$menus = var_export($menus, true);
		$menus = preg_replace("/(\d+|'id'|'pid') =>(.*)/", '', $menus);
		$menus = preg_replace("/'child' => (.*)(\r\n|\r|\n)\s*array/", "'child' => $1array", $menus);
		$menus = str_replace(['array (', ')'], ['[', ']'], $menus);
		$menus = preg_replace("/(\s*?\r?\n\s*?)+/", "\n", $menus);

		$content = <<<INFO
<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

/**
 * 菜单信息
 */
return {$menus};

INFO;
		// 写入到文件
		return file_put_contents(Env::get('root_path') . 'export/module/' . $name . '/menus.php', $content);
	}

	/**
	 * 创建模块配置文件
	 * @param array $info 模块配置信息
	 * @param string $name 模块名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return int
	 */
	private function buildInfoFile($info = [], $name = '')
	{
		// 美化数组格式
		$info = var_export($info, true);
		$info = preg_replace("/'(.*)' => (.*)(\r\n|\r|\n)\s*array/", "'$1' => array", $info);
		$info = preg_replace("/(\d+) => (\s*)(\r\n|\r|\n)\s*array/", "array", $info);
		$info = preg_replace("/(\d+ => )/", "", $info);
		$info = preg_replace("/array \((\r\n|\r|\n)\s*\)/", "[)", $info);
		$info = preg_replace("/array \(/", "[", $info);
		$info = preg_replace("/\)/", "]", $info);

		$content = <<<INFO
<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

/**
 * 模块信息
 */
return {$info};

INFO;
		// 写入到文件
		return file_put_contents(Env::get('root_path') . 'export/module/' . $name . '/info.php', $content);
	}

	/**
	 * 设置状态
	 * @param string $type 类型：disable/enable
	 * @param array $record 行为日志内容
	 * @author 蔡伟明 <314013107@qq.com>
	 * @throws \think\facade\Db\exception\DataNotFoundException
	 * @throws \think\facade\Db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function setStatus($type = '', $record = [])
	{
		$ids = input('param.ids');
		empty($ids) && $this->error('缺少主键');

		$module = ModuleModel::where('id', $ids)->find();
		$module['system_module'] == 1 && $this->error('禁止操作系统内置模块');

		$status = $type == 'enable' ? 1 : 0;

		// 将模块对应的菜单禁用或启用
		$map = [
			'pid'    => 0,
			'module' => $module['name']
		];
		MenuModel::where($map)->update(['status' => $status]);

		if (false !== ModuleModel::where('id', $ids)->update(['status' => $status])) {
			// 记录日志
			call_user_func_array('action_log', ['module_' . $type, 'admin_module', 0, session('UID'), $module['title']]);
			$this->success('操作成功');
		} else {
			$this->error('操作失败');
		}
	}

	/**
	 * 禁用模块
	 * @param array $record 行为日志内容
	 * @author 蔡伟明 <314013107@qq.com>
	 * @throws \think\facade\Db\exception\DataNotFoundException
	 * @throws \think\facade\Db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function disable($record = [])
	{
		$this->setStatus('disable');
	}

	/**
	 * 启用模块
	 * @param array $record 行为日志内容
	 * @author 蔡伟明 <314013107@qq.com>
	 * @throws \think\facade\Db\exception\DataNotFoundException
	 * @throws \think\facade\Db\exception\ModelNotFoundException
	 * @throws \think\exception\DbException
	 */
	public function enable($record = [])
	{
		$this->setStatus('enable');
	}

	/**
	 * 添加模型菜单
	 * @param array $menus 菜单
	 * @param string $module 模型名称
	 * @param int $pid 父级ID
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return bool
	 */
	private function addMenus($menus = [], $module = '', $pid = 0)
	{
		foreach ($menus as $menu) {
			$data = [
				'pid'         => $pid,
				'module'      => $module,
				'title'       => $menu['title'],
				'icon'        => isset($menu['icon']) ? $menu['icon'] : 'fa fa-fw fa-puzzle-piece',
				'url_type'    => isset($menu['url_type']) ? $menu['url_type'] : 'module_admin',
				'url_value'   => isset($menu['url_value']) ? $menu['url_value'] : '',
				'url_target'  => isset($menu['url_target']) ? $menu['url_target'] : '_self',
				'online_hide' => isset($menu['online_hide']) ? $menu['online_hide'] : 0,
				'status'      => isset($menu['status']) ? $menu['status'] : 1
			];

			$result = MenuModel::create($data);
			if (!$result) return false;

			if (isset($menu['child'])) {
				$this->addMenus($menu['child'], $module, $result['id']);
			}
		}

		return true;
	}

	/**
	 * 检查依赖
	 * @param string $type 类型：module/plugin
	 * @param array $data 检查数据
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return array
	 */
	private function checkDependence($type = '', $data = [])
	{
		$need = [];
		foreach ($data as $key => $value) {
			if (!isset($value[3])) {
				$value[3] = '=';
			}
			// 当前版本
			if ($type == 'module') {
				$curr_version = ModuleModel::where('identifier', $value[1])->value('version');
			} else {
				$curr_version = PluginModel::where('identifier', $value[1])->value('version');
			}
			// dump([$curr_version, $value[2], $value[3]]);
			// 比对版本
			$result = version_compare($curr_version, $value[2], $value[3]);
			$need[$key] = [
				$type => $value[0],
				'identifier' => $value[1],
				'version' => $curr_version ? $curr_version : '未安装',
				'version_need' => $value[3] . $value[2],
				'result' => $result ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>'
			];
		}

		return $need;
	}
}
