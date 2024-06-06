<?php
declare (strict_types = 1);

namespace app\common\command;

use app\index\model\SupervisorApps;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

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
        $bin = $command_arr[0];
        if(!is_file($bin)){
            $app->error_logs = '执行程序不存在';
            $app->save();
            return 404;
        }
        return 0;
    }
}
