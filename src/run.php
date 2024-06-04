<?php

require "vendor/autoload.php";

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\DefaultNotifier;

//$notifier = new DefaultNotifier();
//
//$notification = (new Notification)
//    ->setTitle('Notification title')
//    ->setBody('This is the body of your notification')
//;
//
//$notifier->send($notification);

use KingBes\PhpWebview\WebView;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

$app = new Silly\Application();
global $php_bin,$think_file,$web_root,$web_port,$web_pid_file,$console_bin,$bat_file;
$console_bin = __DIR__.'/../php/console.exe';
$php_bin = __DIR__.'/../php/php.exe';
$bat_file = __DIR__.'/web.bat';
$web_pid_file = __DIR__.'/../php/web_pid';
$think_file = __DIR__.'/think';
$web_root = __DIR__.'/public';
$web_port = 8080;


function listen($output)
{
    $index = 1;
    while(true){
        $output->writeln(sprintf('正在进行第%d轮 检测', $index));
        sleep(1);
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
    listen($output);
    $output->writeln('任务监听正在运行');
});

function is_web_running($port){
    $descriptorspec = [STDIN, ['pipe', 'w'], ['pipe', 'w']];
    $cmd = '"netstat" -aon | findstr '.$port.' | findstr /i listening';
    $proc = proc_open($cmd, $descriptorspec, $pipes);
    $ret = stream_get_contents($pipes[1]);
//    echo $ret;
    proc_close($proc);
    return trim($ret);
}

function kill_process($pid){
//    $process = new Process(['taskkill', '/f', '/pid', $pid]);
    $descriptorspec = [STDIN, ['pipe', 'w'], ['pipe', 'w']];
    $cmd = '"taskkill" /F /PID '.$pid;
    var_dump($cmd);
    $proc = proc_open($cmd, $descriptorspec, $pipes);
    $ret = stream_get_contents($pipes[1]);
//    echo $ret;
    proc_close($proc);
    return str_contains($ret, 'has been terminated');
//    $process->run();
//    $ret = $process->getOutput();
//    var_dump($ret);
//    return $ret;
}

$app->command('supervisord-web:start', function ($input, $output) {
    global $web_port, $bat_file;
    if(is_web_running($web_port)){
        $output->writeln('web already running');
    }else{
        global $console_bin,$php_bin,$think_file;
//        $web = new Process([
////            $console_bin,
//            $bat_file, $web_port
//        ]);
        $web = new Process([
           $php_bin, $think_file , 'run', '--port', $web_port
        ]);
        $web->setTimeout(null);
        $output->writeln($web->getCommandLine());

        $web->start();
        $web->wait();
        $output->writeln('web running');
//        file_put_contents($web_pid_file, $web->getPid());
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
        $output->writeln('web not running');
    }
});

$app->command('supervisord:run-gui', function ($input, $output) use($app){
    global $web_port,$php_bin;
    if(!is_web_running($web_port)){
        $greetInput = new ArrayInput([
            // the command name is passed as first argument
            'command' => 'supervisord-web:start',
        ]);
        $returnCode = $app->doRun($greetInput, $output);
        if($returnCode !== 0){
            $output->writeln("web can't start");
            return $returnCode;
        }
    }
    $webview = new WebView('supervisor 管理', 800, 600, true, __DIR__.'../');
    $url = "http://localhost:{$web_port}";
    $webview->navigate($url);
    // 运行
    $webview->run();
    // 销毁
    $webview->destroy();
    return 0;
});

$app->run();