<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

return [
	'default'      => env('QUEUE_TYPE', 'redis'),
	'connections'  => [
		'sync'     => [
			'type' => 'sync',
		],
		'database' => [
			'type'       => 'database',
			'queue'      => 'default',
			'table'      => 'jobs',
			'connection' => null,
		],
		'redis'    => [
			'type'       => 'redis',
			'queue'      => 'default',
			'host'       => env('QUEUE_REDIS_HOST', '127.0.0.1'),
			'port'       => env('QUEUE_REDIS_PORT', '6379'),
			'password'   => env('QUEUE_REDIS_AUTH', ''),
			'select'     => env('QUEUE_REDIS_SELECT', 1),
			'timeout'    => 0,
			'persistent' => false,
		],
	],
	'failed'      => [
		'type'  => 'none',
		'table' => 'failed_jobs',
	],
];
