<?php
declare (strict_types = 1);

namespace app\common\command;

use app\index\model\SupervisorApps;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

class AppRunning extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('app_running')
            ->setDescription('判断命令是否在运行')
            ->addArgument('id', Argument::REQUIRED, "app_id to check running");;
    }

    protected function execute(Input $input, Output $output)
    {
        $app = SupervisorApps::find($input->getArgument('id'));
        $output->writeln("checking APP_ID:{$app->id}, PID:{$app->pid}");
        if(!$app){
            return 0;
        }
        $process = $this->checking($app->pid);
        $output->writeln($process? 'running': 'not running');
        return $process?1:0;
        // 指令输出
    }

    private function checking(int $pid){
        $descriptorspec = [STDIN, ['pipe', 'w'], ['pipe', 'w']];
        $cmd = '"tasklist" /fi "pid eq '.$pid.'"';
        $proc = proc_open($cmd, $descriptorspec, $pipes);
        $ret = stream_get_contents($pipes[1]);
        proc_close($proc);
        return trim($ret);
    }
}
