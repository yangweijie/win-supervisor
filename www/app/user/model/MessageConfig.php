<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\user\model;

use think\Model;

/**
 * 角色模型
 * @package app\admin\model
 */
class MessageConfig extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $name = 'admin_message_config';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    /**
     * 获取当前用户未读消息数量
     * @author 蔡伟明 <314013107@qq.com>
     * @return int|string
     */
    public static function getMessageCount()
    {
        return self::where(['status' => 0, 'uid_receive' => session('UID')])->count();
    }
}
