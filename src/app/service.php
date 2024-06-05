<?php

use app\common\service\Console\AutoRegModeConsoleService;
use app\common\service\MultiApp\Service;

// 系统服务定义文件
// 服务在完成全局初始化之后执行
return [

	Service::class,
	AutoRegModeConsoleService::class,
];
