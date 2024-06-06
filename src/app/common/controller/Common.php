<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\common\controller;

use app\BaseController;
use think\Controller;
use think\facade\App;
use think\facade\Db;
use think\facade\View;

/**
 * 项目公共控制器
 * @package app\common\controller
 */
class Common extends BaseController
{
	/**
	 * 初始化
	 * @author 蔡伟明 <314013107@qq.com>
	 */
	protected function initialize()
	{

		// 后台公共模板
		View::assign('_admin_base_layout', config('app.admin_base_layout'));
		// 当前配色方案
		View::assign('system_color', config('asystem_color'));
		// 输出弹出层参数
		View::assign('_pop', $this->request->param('_pop'));
	}

	/**
	 * 获取筛选条件
	 * @author 蔡伟明 <314013107@qq.com>
	 * @alter 小乌 <82950492@qq.com>
	 * @return array
	 */
	final protected function getMap()
	{
		$search_field     = input('param.search_field/s', '', 'trim');
		$keyword          = input('param.keyword/s', '', 'trim');
		$filter           = input('param._filter/s', '', 'trim');
		$filter_content   = input('param._filter_content/s', '', 'trim');
		$filter_time      = input('param._filter_time/s', '', 'trim');
		$filter_time_from = input('param._filter_time_from/s', '', 'trim');
		$filter_time_to   = input('param._filter_time_to/s', '', 'trim');
		$select_field     = input('param._select_field/s', '', 'trim');
		$select_value     = input('param._select_value/s', '', 'trim');
		$search_area      = input('param._s', '', 'trim');
		$search_area_op   = input('param._o', '', 'trim');

		$map = [];

		// 搜索框搜索
		if ($search_field != '' && $keyword !== '') {
			$map[] = [$search_field, 'like', "%$keyword%"];
		}

		// 下拉筛选
		if ($select_field != '') {
			$select_field = array_filter(explode('|', $select_field), 'strlen');
			$select_value = array_filter(explode('|', $select_value), 'strlen');
			foreach ($select_field as $key => $item) {
				if ($select_value[$key] != '_all') {
					if (!in_array($item, ['province', 'city', 'county', 'town', 'village'])) {

						$map[] = [$item, '=', $select_value[$key]];
					}
				}
			}
		}

		// 时间段搜索
		if ($filter_time != '' && $filter_time_from != '' && $filter_time_to != '') {
			$map[] = [$filter_time, 'between time', [$filter_time_from . ' 00:00:00', $filter_time_to . ' 23:59:59']];
		}

		// 表头筛选
		if ($filter != '') {
			$filter         = array_filter(explode('|', $filter), 'strlen');
			$filter_content = array_filter(explode('|', $filter_content), 'strlen');
			foreach ($filter as $key => $item) {
				if (isset($filter_content[$key])) {
					$map[] = [$item, 'in', $filter_content[$key]];
				}
			}
		}

		// 搜索区域
		if ($search_area != '') {
			$search_area = explode('|', $search_area);
			$search_area_op = explode('|', $search_area_op);
			foreach ($search_area as $key => $item) {
				list($field, $value) = explode('=', $item);
				$value = trim($value);
				$op    = explode('=', $search_area_op[$key]);
				if ($value != '') {
					switch ($op[1]) {
						case 'like':
							$map[] = [$field, 'like', "%$value%"];
							break;
						case 'between time':
						case 'not between time':
							$value = explode(' - ', $value);
							if ($value[0] == $value[1]) {
								$value[0] = date('Y-m-d', strtotime($value[0])) . ' 00:00:00';
								$value[1] = date('Y-m-d', strtotime($value[1])) . ' 23:59:59';
							}
						default:
							$map[] = [$field, $op[1], $value];
					}
				}
			}
		}
		return $map;
	}

	public $area_key = [];
	function getMapValue($key = null, $default = null)
	{
		$this->area_key[] = $key;
		$params = $this->getMap();
		if (!$params) {
			return $default;
		}
		if ($key === null) {
			$new_params = [];
			foreach ($params as $key => $value) {
				if (!in_array($value[0], $this->area_key)) {
					$new_params[] = $value;
				}
			}
			return $new_params;
		}
		if ($default === null) {
			return false;
		}

		foreach ($params as $n =>  $items) {

			if ($key == $items[0]) {
				$value = $items[2];

				return $value;
			} else {
				return $default ?: false;
			}
		}
	}

	public function getAreaParam($area = [])
	{
		$select_field     = input('param._select_field/s', '', 'trim');
		$select_value     = input('param._select_value/s', '', 'trim');

		if ($select_field != '') {
			$select_field = array_filter(explode('|', $select_field), 'strlen');
			$select_value = array_filter(explode('|', $select_value), 'strlen');
			foreach ($select_field as $key => $item) {
				if (in_array($item, ['province', 'city', 'county', 'town', 'village'])) {
					if ($select_value[$key] == '_all') {
						$area[] = '';
					} else {
						$area[$item] = $select_value[$key];
					}
				}
			}
		}
		return [
			 	['area_region', 'like', '%' . join('', $area) . '%'],
			  $area
		];
	}
	public function getAreaIdByPid($pid = null)
	{
		if (!$pid) {
			return '';
		}
		$res_area =	Db::name('area_stepless')->where('pid', $pid)->find();
		if ($res_area) {
			return $res_area['id'];
		} else {
			return false;
		}
	}



	/**
	 * 获取字段排序
	 * @param string $extra_order 额外的排序字段
	 * @param bool $before 额外排序字段是否前置
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return string
	 */
	final protected function getOrder($extra_order = '', $before = false)
	{
		$order = input('param._order/s', '');
		$by    = input('param._by/s', '');
		if ($order == '' || $by == '') {
			return $extra_order;
		}
		if ($extra_order == '') {
			return $order . ' ' . $by;
		}
		if ($before) {
			return $extra_order . ',' . $order . ' ' . $by;
		} else {
			return $order . ' ' . $by . ',' . $extra_order;
		}
	}

	/**
	 * 渲染插件模板
	 * @param string $template 模板文件名
	 * @param string $suffix 模板后缀
	 * @param array $vars 模板输出变量
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	final protected function pluginView($template = '', $suffix = '', $vars = [])
	{
		$plugin_name = input('param.plugin_name');

		if ($plugin_name != '') {
			$plugin = $plugin_name;
			$action = 'index';
		} else {
			$plugin = input('param._plugin');
			$action = input('param._action');
		}
		$suffix = $suffix == '' ? 'html' : $suffix;
		$template = $template == '' ? $action : $template;
		$template_path = config('app.plugin_path') . "{$plugin}/view/{$template}.{$suffix}";
		return View::fetch($template_path, $vars);
	}

    /**
     * 快速编辑
     * @param array $record 行为日志内容
     * @author 蔡伟明 <314013107@qq.com>
     */
    public function quickEdit($record = [])
    {
        $field           = input('post.name', '');
        $value           = input('post.value', '');
        $type            = input('post.type', '');
        $id              = input('post.pk', '');
        $validate        = input('post.validate', '');
        $validate_fields = input('post.validate_fields', '');

        $field == '' && $this->error('缺少字段名');
        $id    == '' && $this->error('缺少主键值');

        $Model = $this->getCurrModel();
        $protect_table = [
            '__ADMIN_USER__',
            '__ADMIN_ROLE__',
            config('database.connections')[config('database.default')]['prefix'] . 'admin_user',
            config('database.connections')[config('database.default')]['prefix'] . 'admin_role',
        ];

        // 验证是否操作管理员
        if (in_array($Model->getTable(), $protect_table) && $id == 1) {
            $this->error('禁止操作超级管理员');
        }

        // 验证器
        if ($validate != '') {
            $validate_fields = array_flip(explode(',', $validate_fields));
            if (isset($validate_fields[$field])) {
                $result = $this->validate([$field => $value], $validate . '.' . $field);
                if (true !== $result) $this->error($result);
            }
        }

        switch ($type) {
            // 日期时间需要转为时间戳
            case 'combodate':
                $value = strtotime($value);
                break;
            // 开关
            case 'switch':
                $value = $value == 'true' ? 1 : 0;
                break;
            // 开关
            case 'password':
                $value = Hash::make((string)$value);
                break;
        }

        // 主键名
        $pk     = $Model->getPk();
        $result = $Model->where($pk, $id)->update([$field => $value]);

        cache('hook_plugins', null);
        cache('system_config', null);
        cache('access_menus', null);
        if (false !== $result) {
            // 记录行为日志
            if (!empty($record)) {
                call_user_func_array('action_log', $record);
            }
            $this->success('操作成功');
        } else {
            $this->error('操作失败');
        }
    }

    /**
     * 获取当前操作模型
     * @author 蔡伟明 <314013107@qq.com>
     * @return object|\think\facade\Db\Query
     */
    final protected function getCurrModel()
    {
        $table_token = input('param._t', '');
        $module      = app()->http->getName();
        $controller  = parse_name($this->request->controller());

        $table_token == '' && $this->error('缺少参数');
        !session('?' . $table_token) && $this->error('参数错误');

        $table_data = session($table_token);
        $table      = $table_data['table'];

        $Model = null;
        if ($table_data['prefix'] == 2) {
            // 使用模型
            try {
                $Model = App::model($table);
            } catch (\Exception $e) {
                $this->error('找不到模型：' . $table);
            }
        } else {
            // 使用DB类
            $table == '' && $this->error('缺少表名');
            if ($table_data['module'] != $module || $table_data['controller'] != $controller) {
                $this->error('非法操作');
            }

            $Model = $table_data['prefix'] == 0 ? Db::table($table) : Db::name($table);
        }

        return $Model;
    }
}
