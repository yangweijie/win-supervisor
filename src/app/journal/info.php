<?php
return [
    // 模块名[必填]
    'name'        => 'journal',
    // 模块标题[必填]
    'title'       => '期刊',
    // 模块唯一标识[必填]，格式：模块名.开发者标识.module
    'identifier'  => 'journal.yangweijie.plugin',
    // 模块图标[选填]
    'icon'        => 'si si-book-open',
    // 模块描述[选填]
    'description' => '期刊模块',
    // 开发者[必填]
    'author'      => 'yangweijie',
    // 开发者网址[选填]
    'author_url'  => 'yangweijie.cn',
    // 版本[必填],格式采用三段式：主版本号.次版本号.修订版本号
    'version'     => '1.0.0',
    // 模块依赖[可选]，格式[[模块名, 模块唯一标识, 依赖版本, 对比方式]]
    'need_module' => [
        ['admin', 'admin.dolphinphp.module', '1.0.0']
    ],

    'config'=>[],
];