<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\index\controller;

use app\common\builder\ZBuilder;
use app\common\controller\Common;

/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Index extends Common
{
    public function index()
    {
        $ini = <<<INI
[program:test_one]
command=java -jar /data/smallvideo/supervisor/taskApp-exec.jar TaskTestOne  ; 被监控的进程路径
priority=1                    ; 数字越高，优先级越高
numprocs=1                    ; 启动几个进程
autostart=true                ; 随着supervisord的启动而启动
autorestart=true              ; 自动重启
startretries=10               ; 启动失败时的最多重试次数
exitcodes=0                   ; 正常退出代码
stopsignal=KILL               ; 用来杀死进程的信号
stopwaitsecs=10               ; 发送SIGKILL前的等待时间
redirect_stderr=true          ; 重定向stderr到stdout

[program:test_two]
command=java -jar /data/smallvideo/supervisor/taskApp-exec.jar TaskTestOne  ; 被监控的进程路径
priority=1                    ; 数字越高，优先级越高
numprocs=1                    ; 启动几个进程
autostart=true                ; 随着supervisord的启动而启动
autorestart=true              ; 自动重启
startretries=10               ; 启动失败时的最多重试次数
exitcodes=0                   ; 正常退出代码
stopsignal=KILL               ; 用来杀死进程的信号
stopwaitsecs=10               ; 发送SIGKILL前的等待时间
redirect_stderr=true          ; 重定向stderr到stdout
INI;

        $arr = parse_ini_string($ini);
        dd($arr);
        $data_list = [
            [
                'id'=>1,
                'title'=>'1111',
            ]
        ];
        return ZBuilder::make('table')
            ->hideCheckbox(true)
            ->assign('system_color', config('app.system_color'))
            ->assign('_pop', 1)
//            ->addTopButton('contribute', ['title'=>'投稿', 'href'=>url('contribute'), 'class'=>'btn btn-primary one-pan-link-mark'], ['area' => ['800px', '62%']])
            ->addColumns([ // 批量添加数据列
                // ['id',           'ID'],
                ['title',         '目录', 'link', url('detail', ['id'=>'__id__', '_pop'=>1])],
                // ['right_button', '操作', 'btn'],
            ])
            ->setRowList($data_list) // 设置表格数据
            ->fetch(); // 渲染模板
    }

}
