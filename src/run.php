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

use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

$app = new Silly\Application();
global $php_bin,$think_file,$web_root,$web_port,$web_pid_file;
$php_bin = __DIR__.'../php/php.exe';
$web_pid_file = __DIR__.'/web_pid';
$think_file = __DIR__.'/think';
$web_root = __DIR__.'/public';
$web_port = 8080;


$app->command('supervisord [--gui] [--gui_port=]', function ($gui, $gui_port, OutputInterface $output) {
    global $web_port;
    $gui = $gui ?? false;
    $gui_port = $gui_port?? $web_port;
    $web_port = $gui_port;
    $output->writeln('任务监听正在运行');
});

function is_web_running($port){
    $process = new Process(['netstat', '-aon | findstr ',  $port]);
//    $process->setOptions([
//        ''
//    ]);
    $process->start();
    $ret = $process->getOutput();
    return $ret?true:false;
}

$app->command('supervisord-web', function ($input, OutputInterface $output) use($php_bin, $think_file){
    $this->runCommand('start', function($output)use($php_bin, $think_file) {
        global $web_port;
        if(is_web_running($web_port)){
            ;
        }else{
            global $web_root;
            $web = new Process([
                $php_bin, $think_file, 'run', '--port', $web_port, '--root', $web_root,
            ]);
            $web->start();
            global $web_pid_file;
            file_put_contents($web_pid_file, $web->getPid());
            $web->wait();
        }
    });
    $this->runCommand('stop', function($output) use($php_bin, $think_file){

    });
    $this->runCommand('run-gui', $output);
});

$app->run();