<?php
declare (strict_types = 1);

namespace app\common\command;

use app\index\model\SupervisorApps;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class AppStarted extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('appstared')
            ->addArgument('id', Argument::REQUIRED, "app_id to start")
            ->addArgument('pid', Argument::REQUIRED, "app_pid to update")
            ->setDescription('启动命令后更新pid');
    }

    protected function execute(Input $input, Output $output)
    {
        trace(1111);
        $app = SupervisorApps::find($input->getArgument('id'));
        if(!$app){
            return 404;
        }
        $app->pid = $input->getArgument('pid');
        $app->save();
        // 指令输出
        $output->writeln('appstared');
    }
}
