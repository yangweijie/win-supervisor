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
use app\index\model\SupervisorApps;
/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Index extends Common
{
    public function index()
    {
        cookie('__forward__', $_SERVER['REQUEST_URI']);

        // 获取查询条件
        $map = $this->getMap();

        // 数据列表
        $data_list = SupervisorApps::where($map)->order('id desc')->paginate();
        if ($data_list->count()) {
            $page		= $data_list->render();
            $data_list	= $data_list->items();
        }else{
            $data_list = [];
        }
        return ZBuilder::make('table')
            ->setPageTitle('监控应用')
            ->assign('system_color', config('app.system_color'))
            ->assign('_pop', 1)
            ->addTopButton('add', [], true) // 添加顶部按钮
            ->addTopButton('delete') // 添加顶
            ->addColumns([ // 批量添加数据列
                ['id',           'ID'],
                ['name',         '名称'],
                ['command', '命令'],
                ['priority', '优先级'],
                ['create_time', '添加时间'],
                ['update_time', '更新时间'],
                ['right_button', '操作', 'btn'],
            ])
            ->setRowList($data_list) // 设置表格数据
            ->fetch(); // 渲染模板
    }

    public function add(){
        if($this->request->isPost()){
            SupervisorApps::create($this->request->post());
            $this->success('添加成功');
        }else{
            return ZBuilder::make('form')
                // ->setPageTips('如果出现无法添加的情况，可能由于浏览器将本页面当成了广告，请尝试关闭浏览器的广告过滤功能再试。', 'warning')
                ->addFormItems([
                    ['text',   'name', '名称', ''],
                    ['text',   'command', '命令行'],
                ])
                ->fetch();
        }
    }

}
