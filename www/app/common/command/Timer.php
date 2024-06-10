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

class Timer extends Command
{
	/**
	 * @var int
	 */
	protected $timer;

	/**
	 * @var int|float
	 */
	protected $interval = 1;
	//待监听的项目目录
	private $_monitor_dir = '';

	//热更新间隔时间,默认3s
	private $_interval = 0;

	//最后一次同步时间
	private $_last_time = 0;
	/**
	 * 任务列表
	 */
	static protected  $taskList = [];

	protected function configure()
	{
		// 指令配置
		$this->setName('crontab:timer')
			->addArgument('status', Argument::REQUIRED, 'start/stop/reload/status/connections')
			->addOption('d', null, Option::VALUE_NONE, 'daemon(守护进程)方式启动')
			->addOption('i', null, Option::VALUE_OPTIONAL, '多长时间执行一次,可以精确到0.001')
			->setDescription('start/stop/restart 自动搜索应用目录中Crontab文件夹中的定时任务文件');
	}

	protected function init(Input $input, Output $output)
	{
		global $argv;

		if ($input->hasOption('i'))
			$this->interval = floatval($input->getOption('i'));

		$argv[1] = $input->getArgument('status') ?: 'start';
		if ($input->hasOption('d')) {
			$argv[2] = '-d';
		} else {
			unset($argv[2]);
		}
	}

	protected function execute(Input $input, Output $output)
	{
		$this->init($input, $output);
		Worker::$pidFile = app_path() . 'runtime/crontab_timer.pid';
		$task = new Worker();
		date_default_timezone_set('PRC');
		$task->count = 1;
		$task->onWorkerStart = function () {
			// watch files only in daemon mode
			// if (Worker::$daemonize === false) {
			// 	// chek mtime of files per second 
			// 	LibTimer::add(3, [$this, 'monitor']);
			// }
			$this->checkTimerStatus();
			$this->CrontabListener();
		};
		$task->runAll();
	}

	function checkTimerStatus()
	{
		//自动写入文件方便检测是否启动定时任务命令
		new Crontab('*/6 * * * * *', function () {
			file_put_contents(root_path() . 'runtime/.timer', time());
		});
	}

	function CrontabListener()
	{
		$Module =	Module::where(['status' => 1])->column('name');
		foreach ($Module as $item) {
			$CrontabDIr = root_path() . 'app' . DIRECTORY_SEPARATOR . $item . DIRECTORY_SEPARATOR . 'crontab';
			if (is_dir($CrontabDIr)) {
				$CrontabFiles =	scandir($CrontabDIr);
				foreach ($CrontabFiles as $file) {
					$file = $CrontabDIr . DIRECTORY_SEPARATOR . $file;
					if (is_file($file)) {
						$fileName = basename($file, '.php');
						$CrontabClass = '\\app\\' . $item . '\\crontab\\' . $fileName;
						if (class_exists($CrontabClass)) {
							$crontabName_ = $CrontabClass . ' | ' . $CrontabClass::CRONTAB;
							$crontabName = md5($crontabName_);
							if (!isset(self::$taskList[$crontabName])) {
								//获取定时任务时间字符串
								self::$taskList[$crontabName] = new Crontab($CrontabClass::CRONTAB, function () use ($CrontabClass) {
									// dump(date('Y-m-d H:i:s', time()) . ' CrontabListener 任务执行时间');
									try {
										$CrontabClass::handle();
									} catch (ThinkException $th) {
										$array =	['Crontab' => $CrontabClass::CRONTAB, 'Error' => $th->getMessage(), 'File' => $th->getFile(), 'Line' => $th->getLine()];
										$string = implode(", ", array_map(function ($k, $v) {
											return $k . ':' . $v;
										}, array_keys($array), $array));
										Log::alert('任务运行错误：' . $CrontabClass . '|' . $string);
										// Timer::cancelTask($crontabName);
									}
								}, $crontabName);
								// dump(self::$taskList[$crontabName]->getAll());
							}
						}
					}
				}
			}
		}
	}

	/**
	 * 根据任务名称取消任务
	 */
	static	function cancelTask($taskName)
	{
		if (isset(self::$taskList[$taskName])) {
			self::$taskList[$taskName]->destroy();
		}
	}
	private function getCrontabDIr()
	{

		$CrontabDIr =	scandir(root_path() . 'app' . DIRECTORY_SEPARATOR);
		$CrontabDIrs = [];
		foreach ($CrontabDIr as $DIr) {
			$except_module = config('zbuilder.except_module');
			$basename = basename($DIr);
			$crodir =	root_path() . 'app' . DIRECTORY_SEPARATOR  . $basename . DIRECTORY_SEPARATOR . 'crontab';
			// dump([$basename, $except_module, $crodir, is_dir($crodir)]);
			if (is_dir($crodir)) {
				if (!in_array($basename, $except_module)) {
					$CrontabDIrs[] = $crodir;
				}
			}
		}
		return $CrontabDIrs;
	}
	//监听器，kill进程
	public function monitor()
	{
		$CrontabDIrs = $this->getCrontabDIr();
		foreach ($CrontabDIrs as $CrontabDIr) {

			// recursive traversal directory
			$iterator = new RecursiveDirectoryIterator($CrontabDIr);
			$iterator = new RecursiveIteratorIterator($iterator);

			foreach ($iterator as $file) {
				// only check php files
				if (pathinfo($file, PATHINFO_EXTENSION) != 'php') continue;

				// check mtime
				if ($this->_last_time < $file->getMTime()) {
					exec('taskkill -f -pid ' . getmypid());
					$this->_last_time = $file->getMTime();
					return true;
				}
			}		# code...
		}
	}
}
