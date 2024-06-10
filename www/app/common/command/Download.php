<?php
// +----------------------------------------------------------------------
// | CRMEB [ CRMEB赋能开发者，助力企业发展 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2023 https://www.crmeb.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed CRMEB并不是自由软件，未经许可不能去掉CRMEB相关版权
// +----------------------------------------------------------------------
// | Author: CRMEB Team <admin@crmeb.com>
// +----------------------------------------------------------------------
namespace app\common\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use app\common\logic\Download as LogicDownload;
use think\facade\Cache;

class Download extends Command
{
	/**
	 * @var int
	 */
	protected $timer;

	/**
	 * @var int|float
	 */
	protected $interval = 1;

	/**
	 * 任务列表
	 */
	static protected  $taskList = [];

	protected function configure()
	{
		// 指令配置
		$this->setName('test')->setDescription('测试命令');
	}

	protected function execute(Input $input, Output $output)
	{
		// $data =	Cache::pull('download');
		// if($data){
		// 	return	LogicDownload::DbToExcelToFile($data);
		// }
	}
}
