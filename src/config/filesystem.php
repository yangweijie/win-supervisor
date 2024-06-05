<?php

use think\facade\Cache;

$filesystem_config = Cache::get('filesystem_config');
if ($filesystem_config) {
	return $filesystem_config;
} else {
	return [
		// 默认磁盘
		'default' => 'local',
		// 磁盘列表
		'disks'   => [
			'local'  => [
				'type' => 'local',
				'root' => app()->getRootPath() . 'public/uploads',
			],
			'public' => [
				// 磁盘类型
				'type'       => 'local',
				// 磁盘路径
				'root'       => app()->getRootPath() . 'public/uploads',
				// 磁盘路径对应的外部URL路径
				'url'        => '/uploads',
				// 可见性
				'visibility' => 'public',
			],
			// 更多的磁盘配置信息
		],
	];
}
