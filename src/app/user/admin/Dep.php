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
use app\user\model\Dep as DepModel;
use think\facade\Cache;
use think\facade\View;
use util\Tree;

/**
 * 部门管理
 * @package app\admin\controller
 */
class Dep extends Admin
{
	/**
	 * 部门首页
	 * @param string $group 分组
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 * @throws \Exception
	 */
	public function index()
	{
		// 保存模块排序
		if ($this->request->isPost()) {
			$modules = $this->request->post('sort/a');
			if ($modules) {
				$data = [];
				foreach ($modules as $key => $module) {
					$data[] = [
						'id'   => $module,
						'sort' => $key + 1
					];
				}
				$MenuModel = new DepModel();
				if (false !== $MenuModel->saveAll($data)) {
					$this->success('保存成功');
				} else {
					$this->error('保存失败');
				}
			}
		}
		cookie('__forward__', $_SERVER['REQUEST_URI']);

		// 获取节点数据
		$data_list = DepModel::getAllDeps();

		$max_level = $this->request->get('max', 0);



		// 获取节点数据
		$data_list = DepModel::getAllDeps();

		$max_level = $this->request->get('max', 0);

		View::assign('deps', $this->getNestDep($data_list, $max_level));
		View::assign('page_title', '部门管理');
		return View::fetch();
	}

	/**
	 * 新增部门
	 * @param string $pid 所属部门id
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 * @throws \Exception
	 */
	public function add($pid = '')
	{
		// 保存数据
		if ($this->request->isPost()) {
			$data = $this->request->post('', null, 'trim');

			// 验证
			$result = $this->validate($data, 'Dep');
			// 验证失败 输出错误信息
			if (true !== $result) $this->error($result);

			if ($dep = DepModel::create($data)) {

				Cache::clear();
				// 记录行为
				$details = '所属部门ID(' . $data['pid'] . '),部门名称(' . $data['title'] . ')';
				action_log('dep_add', 'admin_dep', $dep['id'], session('UID'), $details);
				$this->success('新增成功', cookie('__forward__'));
			} else {
				$this->error('新增失败');
			}
		}

		// 使用ZBuilder快速创建表单
		return ZBuilder::make('form')
			->setPageTitle('新增部门')
			->addFormItems([
				['select', 'pid', '所属部门', '所属上级部门', DepModel::getDepTree(0, ''), $pid],
				['text', 'title', '部门名称'],
			])
			->addText('sort', '排序', '', 100)
			->fetch();
	}

	/**
	 * 编辑部门
	 * @param int $id 部门ID
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 * @throws \Exception
	 */
	public function edit($id = 0)
	{
		if ($id === 0) $this->error('缺少参数');

		// 保存数据
		if ($this->request->isPost()) {
			$data = $this->request->post('', null, 'trim');

			// 验证
			$result = $this->validate($data, 'Dep');
			// 验证失败 输出错误信息
			if (true !== $result) $this->error($result);

			if (DepModel::update($data)) {
				Cache::clear();
				// 记录行为
				$details = '所属部门ID(' . $data['pid'] . '),部门名称(' . $data['title'] . ')';
				action_log('dep_edit', 'admin_dep', $id, session('UID'), $details);
				$this->success('编辑成功', cookie('__forward__'));
			} else {
				$this->error('编辑失败');
			}
		}

		// 获取数据
		$info = DepModel::find($id);


		// 使用ZBuilder快速创建表单
		return ZBuilder::make('form')
			->setPageTitle('编辑部门')
			->addFormItem('hidden', 'id')
			->addFormItem('select', 'pid', '所属部门', '所属上级部门', DepModel::getDepTree(0, ''))
			->addFormItem('text', 'title', '部门名称')
			->addText('sort', '排序', '', 100)
			->setFormData($info)
			->fetch();
	}

	/**
	 * 删除部门
	 * @param array $record 行为日志内容
	 * @author 蔡伟明 <314013107@qq.com>
	 */
	public function delete($record = [])
	{
		$id = $this->request->param('id');
		$dep = DepModel::where('id', $id)->find();

		if ($dep['system_dep'] == '0') $this->error('系统部门，禁止删除');

		// 获取该部门的所有后辈部门id
		$dep_childs = DepModel::getChildsId($id);

		// 要删除的所有部门id
		$all_ids = array_merge([(int)$id], $dep_childs);

		// 删除部门
		if (DepModel::destroy($all_ids)) {
			Cache::clear();
			// 记录行为
			$details = '部门ID(' . $id . '),部门名称(' . $dep['title'] . ')';
			action_log('dep_delete', 'admin_dep', $id, session('UID'), $details);
			$this->success('删除成功');
		} else {
			$this->error('删除失败');
		}
	}

	/**
	 * 保存部门排序
	 * @author 蔡伟明 <314013107@qq.com>
	 */
	public function save()
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();
			if (!empty($data)) {
				$deps = $this->parseDep($data['deps']);
				foreach ($deps as $dep) {
					if ($dep['pid'] == 0) {
						continue;
					}
					DepModel::update($dep);
				}
				Cache::clear();
				$this->success('保存成功');
			} else {
				$this->error('没有需要保存的部门');
			}
		}
		$this->error('非法请求');
	}

	/**
	 * 递归解析部门
	 * @param array $deps 部门数据
	 * @param int $pid 上级部门id
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return array 解析成可以写入数据库的格式
	 */
	private function parseDep($deps = [], $pid = 0)
	{
		$sort   = 1;
		$result = [];
		foreach ($deps as $dep) {
			$result[] = [
				'id'   => (int)$dep['id'],
				'pid'  => (int)$pid,
				'sort' => $sort,
			];
			if (isset($dep['children'])) {
				$result = array_merge($result, $this->parseDep($dep['children'], $dep['id']));
			}
			$sort++;
		}
		return $result;
	}

	/**
	 * 获取嵌套式部门
	 * @param array $lists 原始部门数组
	 * @param int $pid 父级id
	 * @param int $max_level 最多返回多少层，0为不限制
	 * @param int $curr_level 当前层数
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return string
	 */
	private function getNestDep($lists = [], $max_level = 0, $pid = 0, $curr_level = 1)
	{
		$result = '';
		foreach ($lists as $key => $value) {
			if ($value['pid'] == $pid) {
				$disable  = $value['status'] == 0 ? 'dd-disable' : '';

				// 组合部门
				$result .= '<li class="dd-item dd3-item ' . $disable . '" data-id="' . $value['id'] . '">';
				$result .= '<div class="dd-handle dd3-handle">拖拽</div><div class="dd3-content">' . $value['title'];

				$result .= '<div class="action">';
				$result .= '<a href="' . url('add', ['pid' => $value['id']]) . '" data-toggle="tooltip" data-original-title="新增子部门"><i class="list-icon fa fa-plus fa-fw"></i></a><a href="' . url('edit', ['id' => $value['id']]) . '" data-toggle="tooltip" data-original-title="编辑"><i class="list-icon fa fa-pencil fa-fw"></i></a>';
				if ($value['status'] == 0) {
					// 启用
					$result .= '<a href="javascript:void(0);" data-ids="' . $value['id'] . '" class="enable" data-toggle="tooltip" data-original-title="启用"><i class="list-icon fa fa-check-circle-o fa-fw"></i></a>';
				} else {
					// 禁用
					$result .= '<a href="javascript:void(0);" data-ids="' . $value['id'] . '" class="disable" data-toggle="tooltip" data-original-title="禁用"><i class="list-icon fa fa-ban fa-fw"></i></a>';
				}
				$result .= '<a href="' . url('delete', ['id' => $value['id'], 'table' => 'admin_dep']) . '" data-toggle="tooltip" data-original-title="删除" class="ajax-get confirm"><i class="list-icon fa fa-times fa-fw"></i></a></div>';
				$result .= '</div>';

				if ($max_level == 0 || $curr_level != $max_level) {
					unset($lists[$key]);
					// 下级部门
					$children = $this->getNestDep($lists, $max_level, $value['id'], $curr_level + 1);
					if ($children != '') {
						$result .= '<ol class="dd-list">' . $children . '</ol>';
					}
				}

				$result .= '</li>';
			}
		}
		return $result;
	}

	/**
	 * 启用部门
	 * @param array $record 行为日志
	 * @author 蔡伟明 <314013107@qq.com>
	 */
	public function enable($record = [])
	{
		$id			= input('param.ids');
		$dep		= DepModel::where('id', $id)->find();
		$details	= '部门ID(' . $id . '),部门名称(' . $dep['title'] . ')';
		$this->setStatus('enable', ['dep_enable', 'admin_dep', $id, session('UID'), $details]);
	}

	/**
	 * 禁用部门
	 * @param array $record 行为日志
	 * @author 蔡伟明 <314013107@qq.com>
	 */
	public function disable($record = [])
	{
		$id			= input('param.ids');
		$dep		= DepModel::where('id', $id)->find();
		$details	= '部门ID(' . $id . '),部门名称(' . $dep['title'] . ')';
		$this->setStatus('disable', ['dep_disable', 'admin_dep', $id, session('UID'), $details]);
	}

	/**
	 * 设置状态
	 * @param string $type 类型
	 * @param array $record 行为日志
	 * @author 小乌 <82950492@qq.com>
	 */
	public function setStatus($type = '', $record = [])
	{
		$id = input('param.ids');

		$status = $type == 'enable' ? 1 : 0;

		if (false !== DepModel::where('id', $id)->update(['status' => $status])) {
			Cache::clear();
			// 记录行为日志
			if (!empty($record)) {
				call_user_func_array('action_log', $record);
			}
			$this->success('操作成功');
		} else {
			$this->error('操作失败');
		}
	}

	public function get_dps()
	{
		Tree::config([
			'id'    => 'id',    // id名称
			'pid'   => 'pid',   // pid名称
			'title' => 'deptname', // 标题名称
			'child' => 'children', // 子元素键名
			'child_end_empty'	=> true,
			'display_fields'	=> ['id', 'deptname'],
		]);
		$deptdata = DepModel::getAllDeps('id,pid,title as deptname');
		$deptdata  =  Tree::toLayer($deptdata);
		// die;
		return json(['data' => $deptdata]);
	}
}
