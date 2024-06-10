<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\admin\validate;

use think\Validate;
use util\Crypt;

/**
 * 钩子验证器
 * @package app\admin\validate
 * @author 蔡伟明 <314013107@qq.com>
 */
class Download extends Validate
{
	//定义验证规则
	protected $rule = [
		'module|应用名称'  => 'require',
		'title|下载内容标题'  => 'require',
		'sql|应用下载参数'  => 'require|checkSql:true',
	];

	//定义验证提示
	protected $message = [
		'name.regex' => '钩子名称由字母和下划线组成',
	];

	// 检查下载sql语句解密是否正确
	protected function checkSql($value, $rule, $data = [])
	{
		return Crypt::decode($value) ? true : '应用下载参数错误，请检查下载参数是否正确！';
	}
}
