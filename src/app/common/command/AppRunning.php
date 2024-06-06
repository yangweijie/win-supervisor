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
        if(!$app){
            return 0;
        }
        $bin = SupervisorApps::getBin($app->command);
        $bin_file = $bin = pathinfo($bin, PATHINFO_BASENAME);
        $output->writeln("checking APP_ID:{$app->id}, bin:{$bin_file}");
        $process = $this->checking($bin_file);
        dump($process);
        $output->writeln(!str_contains($process, 'No tasks are running')? 'running': 'stopped');
        return $process?1:0;
        // 指令输出
    }

    private function checking(string $bin){
        $descriptorspec = [STDIN, ['pipe', 'w'], ['pipe', 'w']];
        $cmd = 'tasklist /svc /FI "IMAGENAME eq '.$bin.'"';
        $proc = proc_open($cmd, $descriptorspec, $pipes);
        $ret = stream_get_contents($pipes[1]);
        proc_close($proc);
        return trim($ret);
    }
}
