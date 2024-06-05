<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\user\validate;

use think\Validate;

/**
 * 部门验证器
 * @package app\admin\validate
 * @author 蔡伟明 <314013107@qq.com>
 */
class Dep extends Validate
{
    //定义验证规则
    protected $rule = [
        'pid|所属部门'    => 'require',
        'title|部门标题'  => 'require',
    ];

    //定义验证提示
    protected $message = [
        'pid.require'    => '请选择所属部门',
    ];
}
