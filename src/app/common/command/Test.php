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

use app\admin\model\Module;
use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\Exception as ThinkException;
use think\facade\Log;
use Workerman\Crontab\Crontab;
use Workerman\Lib\Timer as LibTimer;
use Workerman\Worker;

class Test extends Command
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
		$info = require root_path() . 'app/caring/info.php';

		$tables = $info['tables'];


		foreach ($tables as $key => $table) {

			$this->app->console->call('make:model', ['caring@' . snakeToCamel($table, true)]);
		}
	}
}
