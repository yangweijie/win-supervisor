<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

/**
 * 菜单信息
 */
return [
  [
	'title' => '期刊',
	'icon' => '',
	'url_type' => 'module_admin',
	'url_value' => 'journal/index/index',
	'url_target' => '_self',
	'online_hide' => 1,
	'sort' => 100,
	'status' => 1,
	'child' => [
	  [
		'title' => '期刊',
		'icon' => '',
		'url_type' => 'module_admin',
		'url_value' => 'journal/index/index',
		'url_target' => '_self',
		'online_hide' => 0,
		'sort' => 100,
		'status' => 1,
		'child' => [
		  [
			'title' => '新增',
			'icon' => '',
			'url_type' => 'module_admin',
			'url_value' => 'journal/index/add',
			'url_target' => '_self',
			'online_hide' => 0,
			'sort' => 100,
			'status' => 1,
		  ],
		  [
			'title' => '编辑',
			'icon' => '',
			'url_type' => 'module_admin',
			'url_value' => 'journal/index/edit',
			'url_target' => '_self',
			'online_hide' => 0,
			'sort' => 100,
			'status' => 1,
		  ],
		  [
			'title' => '删除',
			'icon' => '',
			'url_type' => 'module_admin',
			'url_value' => 'journal/index/delete',
			'url_target' => '_self',
			'online_hide' => 0,
			'sort' => 100,
			'status' => 1,
		  ],
		  [
			'title' => '启用',
			'icon' => '',
			'url_type' => 'module_admin',
			'url_value' => 'journal/index/enable',
			'url_target' => '_self',
			'online_hide' => 0,
			'sort' => 100,
			'status' => 1,
		  ],
		  [
			'title' => '禁用',
			'icon' => '',
			'url_type' => 'module_admin',
			'url_value' => 'journal/index/disable',
			'url_target' => '_self',
			'online_hide' => 0,
			'sort' => 100,
			'status' => 1,
		  ],
		  [
			'title' => '快速编辑',
			'icon' => '',
			'url_type' => 'module_admin',
			'url_value' => 'journal/index/quickedit',
			'url_target' => '_self',
			'online_hide' => 0,
			'sort' => 100,
			'status' => 1,
		  ],
		  [
			'title' => '开启采集',
			'icon' => '',
			'url_type' => 'module_admin',
			'url_value' => 'journal/index/start',
			'url_target' => '_self',
			'online_hide' => 0,
			'sort' => 100,
			'status' => 1,
		  ],
		  [
			'title' => '停止采集',
			'icon' => '',
			'url_type' => 'module_admin',
			'url_value' => 'journal/index/stop',
			'url_target' => '_self',
			'online_hide' => 0,
			'sort' => 100,
			'status' => 1,
		  ],
		],
	  ],
	],
  ],
];
