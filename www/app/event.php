<?php
// 事件定义文件
return [
	'bind'      => [],

	'listen'    => [
		'AppInit'  => [
        ],
		'HttpRun'  => [
			'app\\common\\event\\InitRoute',
			'app\\common\\event\\AdminAuth',
			'app\\common\\event\\Config',
			'app\\common\\event\\Hook',
		],
		'HttpEnd'  => [],
		'LogLevel' => [],
		'LogWrite' => [],
	],

	'subscribe' => [],
];
