<?php

namespace app\index\service;

use app\index\command\AppListen;
use app\index\command\AppRunning;
use app\index\command\AppStart;
use think\Service as BaseService;

class Supervisor extends BaseService {
	public function is_think_run_init() {
		$request = $this->app->request;
		return $request->isCli() && isset($request->server()['argv']) && $request->server()['argv'][1] == 'run';
	}

	public function boot() {
		$this->commands([
			'supervisor:listen' => AppListen::class,
			'supervisor:app_running' => AppRunning::class,
			'supervisor:app_start' => AppStart::class,
		]);

		register_shutdown_function([$this, 'appShutdown']);

		$php_bin = get_php_exe();
		$think = root_path() . 'think';
		trace('pid:' . getmypid());
		trace(datetime());
//        trace(request()->isCli());
		trace('is_think_run_init');
		trace($this->is_think_run_init() ? 'true' : 'false');
		if ($this->is_think_run_init()) {
			$pid = cache('supervisor_listen_pid') ?: 0;
			trace('listen_pid:' . $pid);
			$this->app->request->is_think_run_init = true;
			if (!process_runing_by_pid($pid)) {
				//            dump($think);
				trace('listen starting');
				$commandString = 'start /B ' . $php_bin . ' ' . $think . ' supervisor:listen > ' . runtime_path() . 'log/listen.log';
//                trace($commandString);
				// $commandString = $php_bin. ' '.$cmd_file;
				// var_dump($commandString);
				pclose(popen($commandString, 'r'));
			} else {
				trace('listen running');
			}
		}
	}

	public function appShutdown() {
		trace(datetime());
		trace('in shutdown');
		$is_think_run_init = $this->app->request->is_think_run_init ?? false;
		trace('think_run?' . ($is_think_run_init ? 'true' : 'false'));
		if ($is_think_run_init) {
			$pid = cache('supervisor_listen_pid') ?: 0;
			if ($pid) {
				kill_process($pid);
				cache('supervisor_listen_pid', null);
			}
		}
	}
}
