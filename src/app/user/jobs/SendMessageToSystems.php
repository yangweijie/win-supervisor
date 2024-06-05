<?php

namespace app\user\jobs;

use think\facade\Log;
use think\facade\Queue;
use think\queue\Job;

class SendMessageToSystems
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
		 
		if (isset($data['uid_send']) && isset($data['uid_receive']) && isset($data['data'])) {

			$uids = is_array($data['uid_receive']) ? $data['uid_receive'] : explode(',', $data['uid_receive']);
			$list = [];
			foreach ($uids as $uid) {
				$list[] = [
					'uid_receive' => $uid,
					'uid_send'    => $data['uid_send'],
					'type'        => $data['data']['type'],
					'content'     => $data['data']['content'],
				];
			}

			$MessageModel = model('user/message');
			$res = false !== $MessageModel->saveAll($list);
			Log::error('this is Jobs ' . __CLASS__ . time());

			return $res ? true : false;
		} else {
			return false;
		}
	}
}
