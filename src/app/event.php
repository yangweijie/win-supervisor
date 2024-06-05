<?php
// 事件定义文件
return [
	'bind'      => [],

	'listen'    => [
		'AppInit'  => [],
		'HttpRun'  => [
			'app\\common\\event\\InitRoute',
			'app\\common\\event\\AdminAuth',
			'app\\common\\event\\Config',
			'app\\common\\event\\Hook',
		],
		'HttpEnd'  => [],
		'LogLevel' => [],
		'LogWrite' => [],
		'CrontabListener' => [ //定时任务事件
			'app\\common\\event\\SystemCrontabListener'
		],
		'UserRegister' => [
			'app\\user\\common\\event\\UserRegister'
		],
	],

	'subscribe' => [],
];
