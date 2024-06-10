<?php
namespace app\index\event;

use think\App;

class Supervisor{
    /**
     * 路径入口判断
     * @var string
     */
    protected $appname;
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function handle($event)
    {

    }
}