<?php

require "vendor/autoload.php";

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\DefaultNotifier;


use KingBes\PhpWebview\WebView;
use think\facade\Db;
use think\Env;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Process\Process;

require __DIR__.'/vendor/topthink/framework/src/helper.php';


function notify($title = 'Notification title', $body = 'This is the body of your notification'){
    $notifier = new DefaultNotifier();
    $notification = (new Notification)
        ->setTitle($title)
        ->setBody($body)
    ;
    $send_ret = $notifier->send($notification);
    return $notifier;
}


$env = new Env();
$env->load(__DIR__.'/.env');

Db::setConfig([
    // 默认使用的数据库连接配置
    'default'         => $env->get('DB_DRIVER', 'mysql'),

    // 自定义时间查询规则
    'time_query_rule' => [],

    // 自动写入时间戳字段
    // true为自动识别类型 false关闭
    // 字符串则明确指定时间字段类型 支持 int timestamp datetime date
    'auto_timestamp'  => true,

    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',

    // 时间字段配置 配置格式：create_time,update_time
    'datetime_field'  => '',

    // 数据库连接配置信息
    'connections'     => [
        'mysql' => [
            // 数据库类型
            'type'            => $env->get('DB_TYPE', 'mysql'),
            // 服务器地址
            'hostname'        => $env->get('DB_HOST', '127.0.0.1'),
            // 数据库名
            'database'        => $env->get('DB_NAME', ''),
            // 用户名
            'username'        => $env->get('DB_USER', 'root'),
            // 密码
            'password'        => $env->get('DB_PASS', ''),
            // 端口
            'hostport'        => $env->get('DB_PORT', '3306'),
            // 数据库连接参数
            'params'          => [],
            // 数据库编码默认采用utf8
            'charset'         => $env->get('DB_CHARSET', 'utf8'),
            // 数据库表前缀
            'prefix'          => $env->get('DB_PREFIX', ''),

            // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
            'deploy'          => 0,
            // 数据库读写是否分离 主从式有效
            'rw_separate'     => false,
            // 读写分离后 主服务器数量
            'master_num'      => 1,
            // 指定从服务器序号
            'slave_no'        => '',
            // 是否严格检查字段是否存在
            'fields_strict'   => true,
            // 是否需要断线重连
            'break_reconnect' => false,
            // 监听SQL
            'trigger_sql'     => $env->get('DB_TRIGGER_SQL', true) ? true : $env->get('APP_DEBUG', true),
            // 开启字段缓存
            'fields_cache'    => false,
        ],

        // 更多的数据库配置信息
        'sqlite'=>[
            'type'            => $env->get('DB_TYPE', 'sqlite'),
            'database'        => $env->get('DB_DATABASE', __DIR__.'/../../php/dolphin.db'),
            'trigger_sql'     => true,
            'prefix'          => $env->get('DB_PREFIX', ''),
        ]
    ],
]);

function udate($format = 'u', $utimestamp = null)
{
    if (is_null($utimestamp)){
        $utimestamp = microtime(true);
    }
    $timestamp = floor($utimestamp);
    $milliseconds = round(($utimestamp - $timestamp) * 1000000);//改这里的数值控制毫秒位数
    return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
}

global $appModel;
$appModel = Db::name('supervisor_apps');

$app = new Silly\Application();
global $php_bin,$think_file,$web_root,$web_port,$console_bin,$bat_file;
$console_bin = __DIR__.'/../php/console.exe';
$php_bin = __DIR__.'/../php/php.exe';
$bat_file = __DIR__.'/web.bat';
$think_file = __DIR__.'/think';
$web_root = __DIR__.'/public';
$web_port = 8080;
define('SLEEP_INTERVAL', $env->get('check_interval', 10));

function listen($output, $app)
{
    $index = 1;
    global $appModel;
    while(true){
        $output->writeln(sprintf('%s 正在进行第 %d 轮检测', udate('Y-m-d H:i:s.u'), $index));
        $app_ids = $appModel->where('autostart', 1)->order('priority', 'desc')->column('id');
        foreach($app_ids as $app_id){
            $descriptorspec = [STDIN, ['pipe', 'w'], ['pipe', 'w']];
            $cmd = sprintf('%s think %s %d', __DIR__.'/../php/php.exe', 'common:appstart', $app_id); // 通过端口判断
            $proc = proc_open($cmd, $descriptorspec, $pipes);
            $ret = stream_get_contents($pipes[1]);
            proc_close($proc);
        }
        if(SLEEP_INTERVAL > 100){
            usleep(SLEEP_INTERVAL);
        }else{
            sleep(SLEEP_INTERVAL);
        }
        $index ++;
    }
}

$app->command('supervisord [--gui] [--gui_port=]', function ($gui, $gui_port, OutputInterface $output)use($app) {
    global $web_port,$php_bin;
    $gui = $gui ?? false;
    $gui_port = $gui_port?? $web_port;
    $web_port = $gui_port;
    if($gui){
        $greetInput = new ArrayInput([
            // the command name is passed as first argument
            'command' => 'supervisord:run-gui',
        ]);
        $returnCode = $app->doRun($greetInput, $output);
    }
    listen($output, $app);
    $output->writeln('任务监听正在运行');
});

function is_web_running($port){
    $descriptorspec = [STDIN, ['pipe', 'w'], ['pipe', 'w']];
    $cmd = '"netstat" -aon | findstr '.$port.' | findstr /i listening'; // 通过端口判断
    $proc = proc_open($cmd, $descriptorspec, $pipes);
    $ret = stream_get_contents($pipes[1]);
//    echo $ret;
    proc_close($proc);
    return trim($ret);
}

function kill_process($pid){
    $descriptorspec = [STDIN, ['pipe', 'w'], ['pipe', 'w']];
    $cmd = '"taskkill" /F /PID '.$pid;
    var_dump($cmd);
    $proc = proc_open($cmd, $descriptorspec, $pipes);
    $ret = stream_get_contents($pipes[1]);
    proc_close($proc);
    return str_contains($ret, 'has been terminated');
}

$app->command('supervisord-web:start', function ($input, $output) {
    global $web_port;
    if(is_web_running($web_port)){
        $output->writeln('web already running');
    }else{
        global $php_bin,$think_file;
        $web = new Process([
           $php_bin, $think_file , 'run', '--port', $web_port
        ]);
        $web->setTimeout(null);
        $output->writeln($web->getCommandLine());
        $web->start();
        $web->wait();
        $output->writeln('Web is running');
    }
});

function get_pid_from_port_str($str){
    return str_replace([' ', 'LISTENING'], ['',''], strstr($str, 'LISTENING'));
}

$app->command('supervisord-web:stop', function ($input, $output) {
    global $web_port;
    if($ret = is_web_running($web_port)){
        $current_pid = get_pid_from_port_str($ret);
        var_dump($current_pid);
        if($current_pid){
            if(kill_process($current_pid)){
                $output->writeln('web stopped');
            }
        }else{
            $output->writeln('程序无法杀死为知pid的进程，请任务管理器里结束进程');
        }
    }else{
        $output->writeln('Web not running');
    }
});

$app->command('supervisord:gui', function ($input, $output) use($app, $env){
    global $web_port;
    if(!is_web_running($web_port)){
        $output->writeln("Web not running");
        return 404;
    }
    $webview = new WebView('supervisor 管理', $env->get('win_width', 1024), $env->get('win_height', 800), true, __DIR__);
    $url = "http://localhost:{$web_port}";
    $webview->navigate($url);
    // 运行
    $webview->run();
    // 销毁
    $webview->destroy();
    return 0;
});

$app->run();