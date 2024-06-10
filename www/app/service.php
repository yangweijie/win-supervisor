<?php

use app\common\service\MultiApp\Service;
use app\index\service\Supervisor;

// 系统服务定义文件
// 服务在完成全局初始化之后执行
return [
	Service::class,
    Supervisor::class,
];
