<?php

namespace app\common\amis\facade;

use Exception;
use think\Facade;
use think\facade\View;

class AmisForm extends Facade
{
	/**
	 * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
	 * @access protected
	 * @return string
	 */
	protected static function getFacadeClass()
	{
		return '\\app\\common\\amis\\build\\AmisForm';
	}
}
