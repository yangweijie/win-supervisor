<?php

namespace app\index\command;

use app\index\model\SupervisorApps;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class AppListen extends Command {
	protected function configure() {
		// 指令配置
		$this->setName('listen')
			->setDescription('监听进程');
	}

	protected function execute(Input $input, Output $output) {
		$pid = getmypid();
		cache('supervisor_listen_pid', $pid);
		dump("PID:" . $pid);
		trace('listen_pid' . $pid);
		define('SLEEP_INTERVAL', env('check_interval', 10));
		while (true) {
			$output->writeln(sprintf('%s 正在进行检测', datetime()));
			$apps_ids = SupervisorApps::where('autostart', 1)->order('priority', 'desc')->column('id');
			if (!$apps_ids) {
				$this->output->writeln('暂无需要监听的进程');
			} else {

				$think = root_path() . 'think';
				foreach ($apps_ids as $app_id) {
					// $descriptorspec = [STDIN, ['pipe', 'w'], ['pipe', 'w']];
					// $cmd = sprintf('%s %s %s %d', get_php_exe(), $think, 'supervisor:app_start', $app_id); // 通过端口判断
					// $proc = proc_open($cmd, $descriptorspec, $pipes);
					// $ret = stream_get_contents($pipes[1]);
					// proc_close($proc);
					$url = 'http://localhost:8080/index/index/start?app_id=' . $app_id;
					$ch = curl_init();
					$curl_opt = [
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_TIMEOUT => 1,
					];
					curl_setopt_array($ch, $curl_opt);
					curl_exec($ch);
					curl_close($ch);

				}
			}
			if (SLEEP_INTERVAL > 100) {
				usleep(SLEEP_INTERVAL);
			} else {
				sleep(SLEEP_INTERVAL);
			}
		}
		return 0;
	}
}