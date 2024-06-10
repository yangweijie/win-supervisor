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

namespace app\user\model;

use think\Model;
use util\Tree;

/**
 * 部门模型
 * @package app\admin\model
 */
class Dep extends Model
{
	// 设置当前模型对应的完整数据表名称
	protected $name = 'admin_dep';

	// 自动写入时间戳
	protected $autoWriteTimestamp = true;


	/**
	 * 获取树形部门
	 * @param int $id 需要隐藏的部门id
	 * @param string $default 默认第一个部门项，默认为“顶级部门”，如果为false则不显示，也可传入其他名称
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public static function getDepTree($id = 0, $default = '')
	{
		$result[0] = '顶级部门';
		$where = [
			['status', '>=', 0]
		];


		// 排除指定部门及其子部门
		if ($id !== 0) {
			$hide_ids = array_merge([$id], self::getChildsId($id));
			$where[]  = ['id', 'not in', $hide_ids];
		}

		// 获取部门
		$deps = Tree::toList(self::where($where)->order('pid,id')->column('id,pid,title'));
		foreach ($deps as $dep) {
			$result[$dep['id']] = $dep['title_display'];
		}

		// 设置默认部门项标题
		if ($default != '') {
			$result[0] = $default;
		}

		// 隐藏默认部门项
		if ($default === false) {
			unset($result[0]);
		}

		return $result;
	}

	/**
	 * 获取所有部门
	 * @param string $type 分组名称
	 * @param bool|string $fields 要返回的字段
	 * @param array $map 查找条件
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return array
	 */
	public static function getAllDeps($fields = '*', $map = [])
	{
		$map['status'] = 1;
		return self::where($map)->order('sort,id')->column($fields, 'id');
	}
	/**
	 * 获取顶级部门
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return array
	 */
	public static function getGroup()
	{
		$map['status'] = 1;
		$map['pid']    = 0;
		$deps = self::where($map)->order('id,sort')->column('title');
		return $deps;
	}

	/**
	 * 获取所有子部门id
	 * @param int $pid 父级id
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return array
	 */
	public static function getChildsId($pid = 0)
	{
		$ids = self::where('pid', $pid)->column('id');
		foreach ($ids as $value) {
			$ids = array_merge($ids, self::getChildsId($value));
		}
		return $ids;
	}

	/**
	 * 获取所有父部门id
	 * @param int $id 部门id
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return array
	 */
	public static function getParentsId($id = 0)
	{
		$pid  = self::where('id', $id)->value('pid');
		$pids = [];
		if ($pid != 0) {
			$pids[] = $pid;
			$pids = array_merge($pids, self::getParentsId($pid));
		}
		return $pids;
	}

	/**
	 * 根据部门id获取上下级的所有id
	 * @param int $id 部门id
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return array
	 */
	public static function getLinkIds($id = 0)
	{
		$childs  = self::getChildsId($id);
		$parents = self::getParentsId($id);
		return array_merge((array)(int)$id, $childs, $parents);
	}
}
