<?php

namespace app\user\jobs;

use think\facade\Log;
use think\facade\Queue;
use think\queue\Job;

/**
 * 消息任务分发
 */
class SendMessageToJobs
{
	/**
	 * 接收任务
	 */
	public function fire(Job $job, $data)
	{
		$rt = $this->doJob($data);
		if ($rt) {
			$job->delete();
			return true;
		}

		// 重试三次失败 todo...
		if ($job->attempts() == 3) {
			$job->delete();
			return false;
		}

		//执行失败10S后重试
		$job->release(10);
	}

	/**
	 * 执行任务
	 */
	public function doJob($data)
	{
		//获取模块文件中，info.php 配置文件中注册的消息处理任务 ['jobs']['sendMessage']
		$module_info =	  mergeEnvFiles(root_path() . 'app' . DIRECTORY_SEPARATOR, 'info.php');
		$sendMessageJobs =	$module_info['jobs']['sendMessage'];
		$sendMessageJobs['system'] = 'app\user\jobs\SendMessageToSystems';
		foreach ($data['to_jobs'] as $MessageJobType => $sendData) {
			if (isset($sendMessageJobs[$MessageJobType])) {
				Queue::push($sendMessageJobs[$MessageJobType], ['uid_receive' => $data['uid_receive'], 'uid_send' => $data['uid_send'], 'data' => $sendData], 'sendMessage');
				Log::error('set jobs sendMessage ' . $MessageJobType . ' ' . time());
			}
		}

		return   true;
	}
}
