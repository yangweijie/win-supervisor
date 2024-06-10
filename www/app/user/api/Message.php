<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\user\api;

use app\common\controller\ApiCommon;
use app\user\model\Message as ModelMessage;
use hg\apidoc\annotation as Apidoc;

/**
 * 用户消息
 * @package app\user\admin
 * @Apidoc\Title("用户")
 * @Apidoc\Group("user")
 */
class Message extends ApiCommon
{
	/**
	 * 
	 * 消息列表
	 * @Apidoc\Method("GET")
	 * @Apidoc\Header("token", type="string",require=true, desc="Token")
	 * @Apidoc\Query("id", type="int",require=true, desc="信息id")
	 * @Apidoc\Returned("msg", type="string", desc="消息内容")
	 */
	public function list()
	{
		$data_list = ModelMessage::where($this->getMap())
			->where('uid_receive', $this->user['id'])
			->order($this->getOrder('id DESC'))
			->paginate();
		$this->result($data_list);
	}


	/**
	 * 设置已阅读
	 * @param array $ids
	 * @Apidoc\Query("ids", type="string",require=true, desc="信息id")
	 * @author 蔡伟明 <314013107@qq.com>
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function enable($ids = [])
	{
		empty($ids) && $this->error('参数错误');
		$map = [
			['uid_receive', '=',  $this->user['id']],
			['id', 'in', $ids]
		];
		$result = ModelMessage::where($map)
			->update(['status' => 1, 'read_time' => date('Y-m-d H:i:s', request()->time())]);
		if (false !== $result) {
			$this->success('设置成功');
		} else {
			$this->error('设置失败');
		}
	}
}
