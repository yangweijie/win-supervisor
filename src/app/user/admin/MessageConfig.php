<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\user\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use app\user\model\Message as MessageModel;
use app\user\model\MessageConfig as ModelMessageConfig;
use app\user\model\User as UserModel;
use app\user\model\Role as RoleModel;

/**
 * 消息控制器
 * @package app\user\admin
 */
class MessageConfig extends Admin
{
	/**
	 * 消息列表
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 * @throws \think\Exception
	 * @throws \think\exception\DbException
	 */
	public function index()
	{
		$data_list = ModelMessageConfig::where($this->getMap())->select();

		$columns = [];
		foreach ($data_list as $key =>  $value) {
			$columns[] = [$value['name'], $value['title'], 'status', '', ['禁用', '启用']];
			$config = json_decode($value['config'], true);
			if ($config) {
				$data_list[$key][$value['name']] = $config[$value['name']]['status'];
			}
		}

		return ZBuilder::make('table')
			->setTableName('admin_message')
			->addRightButton('edit')
			->addColumns([
				['id', 'ID'],
				['name', '通知名称', 'text'], //例：user_reagister_msg
				['title', '通知标题', 'text'], //例：用户注册成功消息
				['type', '消息类型', 'text'], //系统、模块、插件
				['desc', '场景说明', 'text'],
			])
			->addColumns($columns) //注册的消息通道启用状态，开启指定的通道，消息才通过该通道发送消息
			->addColumns([
				['status', '状态', 'status', '', ['禁用', '启用']], //消息名称启用状态，此状态禁用后将不会发送任何信息
				['right_button', '操作', 'btn'],
			])
			->setRowList($data_list)
			->fetch();
	}

	/**
	 * 新增
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 * @throws \think\Exception
	 */
	public function edit($hook_name = "", $type_name = '')
	{
		if ($hook_name == '') {
			$this->error('钩子名称不能为空');
		}
		if ($type_name == '') {
			$this->error('类型名称不能为空');
		}
		$info = 	ModelMessageConfig::where('name', $hook_name)->find();
		$config = json_decode($info['config'], true);
		if ($this->request->isPost()) {
			$data = $this->request->post();
			$data['config'] = json_encode(array_merge_recursive($config, $data['config']));
			if (false !== ModelMessageConfig::where('name', $hook_name)->update($data)) {
				$this->success('保存成功', 'index');
			} else {
				$this->error('保存失败');
			}
		}


		$items = [];
		foreach ($config as $key => $value) {
			if ($key == $type_name) {

				$info['variable'] = $value['variable'];
				$info['tpl_str'] = $value['tpl_str'];
				switch ($value) {
					case 'variable':
						$items[] = ['text', 'variable', '变量列表', array_to_str($value['variable'])];
						break;
					case 'tpl_str':
						$items[] = ['text', 'tpl_str', '消息模板'];
						break;

					default:
						# code...
						break;
				}
			}
			$list_tab[] = ['title' => $value['title'], 'url' => url('index', ['group' => $value['title']])];
		}

		return ZBuilder::make('form')
			->setTabNav($list_tab,  $type_name)
			->addFormItems([
				['text', 'name', '消息分类'],
				['text', 'title', '消息内容'],
				['text', 'desc', '消息内容'],
			])
			->addFormItems($items)
			->addFormItems([
				['radio', 'status', '状态', '', ['禁用', '启用']],
			])
			->setFormItems($info)
			->fetch();
	}
}
