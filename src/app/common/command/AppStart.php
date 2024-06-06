<?php
declare (strict_types = 1);

namespace app\common\command;

use app\index\model\SupervisorApps;
use Symfony\Component\Process\ExecutableFinder;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\facade\Console;
use Symfony\Component\Process\Process;
use Swow\Coroutine;

class AppStart extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('appstart')
            ->setDescription('启动命令')
            ->addArgument('id', Argument::REQUIRED, "app_id to start");
    }

    protected function execute(Input $input, Output $output)
    {
        $app = SupervisorApps::find($input->getArgument('id'));
        if(!$app){
            return 404;
        }
        $command = $app->command;
        $command_arr = explode(' ', $command);
        $bin = [];
        foreach ($command_arr as $k => $v) {
            $bin []= $v;
            if(in_array(pathinfo($v, PATHINFO_EXTENSION), ['exe', 'php'])){
                break;
            }
        }
        $bin = implode(' ', $bin);
        print_r($bin);
        if(!is_file($bin)){
            $app->error_logs = '执行程序不存在';
            $app->save();
            return 404;
        }
        // 判断是否在运行
        $output = Console::call('common:apprunning', [strval($app->id)]);
        $ret = $output->fetch();
        dump($ret);
        // 未运行
        if(stripos($ret, 'stopped') !== false){
            $msg = $this->start($app, $bin);
            dump($msg);
        }else{
            $output->writeln('started');
        }
        return 0;
    }

    public function start($app, $bin){
        $descriptorspec = [STDIN, ['pipe', 'w'], ['pipe', 'w']];
        $cmd = str_replace($bin, sprintf('"%s"', $bin), $app->command);
        $proc = proc_open($cmd, $descriptorspec, $pipes, null, null, [
            'bypass_shell'=>true,
            'create_process_group'=>true,
        ]);
        $ret = stream_get_contents($pipes[1]);
        proc_close($proc);
        return trim($ret);
    }

//    public function start($app, $bin){
//        $descriptorspec = [STDIN, ['pipe', 'w'], ['pipe', 'w']];
//        $cmd = str_replace($bin, sprintf('"%s"', $bin), $app->command);
//        $bat_path = __DIR__.'/../../../../php/app_run_'.$app->id.'.bat';
//        dump(realpath($bat_path));
//        $content = <<<BAT
//@echo off
//:: 要启动的进程的完整路径
//set prog_path="{$cmd}"
//:: 启动进程
//start "" %prog_path%
//
//:: 获取进程 ID
//for /F "tokens=1 delims= " %%i in ('tasklist /FI "PID eq %pid%"/FI "imagename eq %prog_path%" 2^>nul') do set pid=%%i
//
//:: 将进程 ID 写入文件
//php think common:appstarted {$app->id} %pid%
//BAT;
//
//        file_put_contents($bat_path, $content);
//        $proc = proc_open($bat_path, $descriptorspec, $pipes, null, null, [
//            'bypass_shell'=>true,
//            'create_process_group'=>true,
//        ]);
//        $ret = stream_get_contents($pipes[1]);
//        proc_close($proc);
//        return trim($ret);
//    }

//    public function start($app, $bin){
////        dump($_SERVER);
//        // 定义要运行的可执行文件的路径
//        $cmd = str_replace($bin, sprintf('"%s"', $bin), $app->command);
//        $executableFinder = new ExecutableFinder();
//        $lsrunas = $executableFinder->find('lsrunas.exe', null, [__DIR__.'/../../../../php']);
//        $runpath = dirname($cmd);
//        // 创建一个新的 Process 对象，并设置要运行的命令
//        $process = new Process([$lsrunas, "/user:{$_SERVER['USERNAME']}",
//            '/password:""', "/domain:{$_SERVER['USERDOMAIN']}",
//            "/command:{$cmd}", "/runpath:{$runpath}"]);
//        dump($process->getCommandLine());
//
//        // 设置 Process 对象的环境变量
////        $process->setEnv([
////            'USERDOMAIN'=>$_SERVER['USERDOMAIN'],
////            'USERNAME'=>$_SERVER['USERNAME'],
////        ]);
//
//        // 以管理员身份运行 Process 对象
////        $process->run();
//
//        // 等待 Process 对象执行完毕
//        $process->start();
//        $process->wait();
//        // 获取 Process 对象的输出
//        $output = $process->getOutput();
//        return[
//            'msg'=>$output,
//            'pid'=>$process->getPid(),
//            'running'=>$process->isRunning(),
//        ];
//    }
}
