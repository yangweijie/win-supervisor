<?php

namespace app\crontab\command;

use app\crontab\model\Crontab as CrontabModel;
use app\crontab\model\CrontabLog as CrontabLogModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use think\Exception;
use think\facade\Db;
use Workerman\Crontab\Crontab;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\Exception as ThinkException;
use think\facade\Log;
use Workerman\Worker;

class UserCrontab  extends Command
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
		$this->setName('crontab:user')
			->addArgument('status', Argument::REQUIRED, 'start/stop/reload/status/connections')
			->addOption('d', null, Option::VALUE_NONE, 'daemon(守护进程)方式启动')
			->addOption('i', null, Option::VALUE_OPTIONAL, '多长时间执行一次,可以精确到0.001')
			->setDescription('start/stop/restart 执行Crontab应用中添加的定时任务');
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
		Worker::$pidFile = app_path() . 'runtime/crontab_user.pid';
		$task = new Worker();
		date_default_timezone_set('PRC');
		$task->count = 1;
		$task->onWorkerStart = function () use ($output) {
			self::handle($output);
		};
		$task->runAll();
	}


	static	function handle(Output $output)
	{
		// 筛选未过期且未完成的任务
		$crontab_list = CrontabModel::where(['status' => 'normal'])->order('weigh desc,id desc')->select();
		if (!$crontab_list) {
			return null;
		}
		foreach ($crontab_list as $key => $crontab) {
			$crontab = $crontab->toArray();

			$crontabName = md5(json_encode($crontab));

			if (!isset(self::$taskList[$crontabName])) {
				$crontab['schedule'] = '* ' . $crontab['schedule'];
				// 自动写入文件方便检测是否启动定时任务命令
				self::$taskList[$crontabName] =	new Crontab($crontab['schedule'], function () use ($crontab, $output) {
					// dump(date('Y-m-d H:i:s', time()) . ' 任务执行时间' . $crontab['schedule']);
					if (time() >= strtotime($crontab['begin_time'])) {   //任务未开始
						$update = [];
						$time = time();
						if ($crontab['maximums'] && $crontab['executes'] > $crontab['maximums']) {  //任务已超过最大执行次数
							$update['status'] = 'completed';
							// dump('任务已超过最大执行次数');
						} else if ($crontab['end_time'] > 0 && $time > $crontab['end_time']) {     //任务已过期
							$update['status'] = 'expired';
							// dump('任务已过期');
						} else {
							// dump('任务开始执行');
							// 允许执行的时候更新状态
							$update['execute_time'] = $time;
							$update['executes'] = $crontab['executes'] + 1;
							$update['status'] = ($crontab['maximums'] > 0 && $update['executes'] >= $crontab['maximums']) ? 'completed' : 'normal';
							$output->writeln('任务执行:' . $crontab['title'] . ' | ' . $crontab['schedule']);
							\think\facade\Db::startTrans();
							try {
								// 分类执行任务
								switch ($crontab['type']) {
									case 'url':
										try {
											$client = new Client();
											$client->request('GET', $crontab['content']);
											static::saveLog('url', $crontab['id'], $crontab['title'], 1, $crontab['content'] . ' 请求成功,HTTP状态码: ');
										} catch (RequestException $e) {
											static::saveLog('url', $crontab['id'], $crontab['title'], 0, $crontab['content'] . ' 请求成功失败: ' . $e->getMessage());
										}
										// dump('任务执行URL任务完成');
										break;
									case 'sql':
										/* 注释中的方法可以一次执行所有SQL语句
										* $connect = \think\Db::connect([], true);
										* $connect->execute("select 1");
										* // 执行SQL
										* count  = $connect->getPdo()->exec($crontab['content']);
										* dump($count );
										*/
										// 解析成一条条的sql语句
										$sqls = str_replace("\r", "\n", $crontab['content']);
										$sqls = explode(";\n", $sqls);
										$remark = '';
										$status = 1;
										foreach ($sqls as $sql) {
											$sql = trim($sql);
											if (empty($sql)) continue;
											if (substr($sql, 0, 2) == '--') continue;   // SQL注释
											// 执行SQL并记录执行结果
											if (false !== Db::execute($sql)) {
												$remark .= '执行成功: ' . $sql . "\r\n\r\n";
											} else {
												$remark .= '执行失败: ' . $sql . "\r\n\r\n";
												$status = 0;
											}
										}
										static::saveLog('sql', $crontab['id'], $crontab['title'], $status, $remark);
										break;
									case 'shell':
										$request = shell_exec($crontab['content'] . ' 2>&1');
										static::saveLog('shell', $crontab['id'], $crontab['title'], 1, $request);
										break;
								}

								CrontabModel::where(['status' => 'normal'])->where('id', $crontab['id'])->update($update);
								$output->writeln($crontab['title'] . ' | ' . $crontab['schedule'] . ' 任务执行完成');
								\think\facade\Db::commit();
							} catch (Exception $e) {
								\think\facade\Db::rollback();
								static::saveLog($crontab['type'], $crontab['id'], $crontab['title'], 0, "执行的内容发生异常:\r\n" . $e->getMessage());
								$output->writeln($crontab['title'] . ' | ' . $crontab['schedule'] . ' 任务执行失败');
							}
						}
					}
				});
				// dump(self::$taskList[$crontabName]->getAll());
			}
		}
	}

	// 保存运行日志
	static	private function saveLog($type, $cid, $title, $status, $remark = '')
	{
		$log = [
			'type'		=>  $type,
			'cid'		=>  $cid,
			'title'		=>  $title,
			'status'	=>  $status,
			'remark'	=>  $remark,
			'create_time' =>  time(),
		];
		// dump($log);  1690631265
		CrontabLogModel::create($log);
	}
}
