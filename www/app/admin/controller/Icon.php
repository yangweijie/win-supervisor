<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\common\builder\ZBuilder;
use app\admin\model\Icon as IconModel;
use app\admin\model\IconList as IconListModel;

/**
 * 图标控制器
 * @package app\admin\controller
 */
class Icon extends Admin
{
    /**
     * 图标列表
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $data_list = IconModel::where($this->getMap())
            ->order($this->getOrder('id DESC'))
            ->paginate();

        return ZBuilder::make('table')
            ->addTopButtons('add,enable,disable,delete')
            ->addRightButton('list', [
                'title' => '图标列表',
                'icon'  => 'fa fa-list',
                'href'  => (string)url('items', ['id' => '__id__'])
            ])
            ->addRightButton('reload', [
                'title' => '更新图标',
                'icon'  => 'fa fa-refresh',
                'class' => 'btn btn-xs btn-default ajax-get confirm',
                'href'  => (string)url('reload', ['id' => '__id__'])
            ])
            ->addRightButton('delete')
            ->setSearch('name')
            ->addColumns([
                ['id', 'ID'],
                ['name', '名称', 'text.edit'],
                ['url', '链接', 'text.edit'],
                ['status', '状态', 'switch'],
                ['create_time', '创建时间', 'datetime'],
                ['right_button', '操作', 'btn'],
            ])
            ->setRowList($data_list)
            ->fetch();
    }

    /**
     * 新增
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post('', null, 'trim');
            $data['name'] == '' && $this->error('请填写名称');
            $data['url'] == '' && $this->error('请填写链接');

            // 获取图标信息
            $url = substr($data['url'], 0, 4) == 'http' ? $data['url'] : 'http:'.$data['url'];
            $content = file_get_contents($url);

            // 获取字体名
            $font_family = '';
            $pattern = '/font-family: "(.*)";/';
            if (preg_match($pattern, $content, $match)) {
                $font_family = $match[1];
            } else {
                $this->error('无法获取字体名');
            }

            $IconModel = new IconModel();
            if ($id = $IconModel->insertGetId($data)) {
                // 拉取图标列表
                $pattern = '/\.(.*):before/';
                if (preg_match_all($pattern, $content, $matches)) {
                    $icon_list = [];
                    foreach ($matches[1] as $match) {
                        $icon_list[] = [
                            'icon_id' => $id,
                            'title'   => $match,
                            'class'   => $font_family . ' ' . $match,
                            'code'    => $match,
                        ];
                    }
                    $IconListModel = new IconListModel();
                    if ($IconListModel->saveAll($icon_list)) {
                        $this->success('新增成功', 'index');
                    } else {
                        $IconModel->where('id', $id)->delete();
                        $this->error('图标添加失败');
                    }
                }
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }

        return ZBuilder::make('form')
            ->addFormItems([
                ['text', 'name', '名称', '可填写中文'],
                ['text', 'url', '链接', '如：//at.alicdn.com/t/font_588968_z5hsg7xluoh41jor.css'],
            ])
            ->fetch();
    }

    /**
     * 图标列表
     * @param string $id
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function items($id = '')
    {
        $data_list = IconListModel::where($this->getMap())
            ->order($this->getOrder('id DESC'))
            ->where('icon_id', $id)
            ->paginate();

        return ZBuilder::make('table')
            ->setTableName('admin_icon_list')
            ->addTopButtons('back')
            ->addTopButton('add', [
                'title' => '更新图标',
                'icon'  => 'fa fa-refresh',
                'class' => 'btn btn-primary ajax-get confirm',
                'href'  => (string)url('reload', ['id' => $id])
            ])
            ->setSearch('title,code')
            ->addColumns([
                ['icon', '图标', 'callback', function($data){
                    return '<i class="'.$data['class'].'"></i>';
                }, '__data__'],
                ['title', '图标标题', 'text.edit'],
                ['code', '图标关键词', 'text.edit'],
                ['class', '图标类名'],
            ])
            ->setRowList($data_list)
            ->fetch();
    }

    /**
     * 更新图标
     * @param string $id
     * @author 蔡伟明 <314013107@qq.com>
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function reload($id = '')
    {
        $icon = IconModel::find($id);
        // 获取图标信息
        $url = substr($icon['url'], 0, 4) == 'http' ? $icon['url'] : 'http:'.$icon['url'];
        $content = file_get_contents($url);

        // 获取字体名
        $font_family = '';
        $pattern = '/font-family: "(.*)";/';
        if (preg_match($pattern, $content, $match)) {
            $font_family = $match[1];
        } else {
            $this->error('无法获取字体名');
        }

        // 拉取图标列表
        $pattern = '/\.(.*):before/';
        if (preg_match_all($pattern, $content, $matches)) {
            $icon_list = [];
            foreach ($matches[1] as $match) {
                $icon_list[] = [
                    'icon_id' => $id,
                    'title'   => $match,
                    'class'   => $font_family . ' ' . $match,
                    'code'    => $match,
                ];
            }
            $IconListModel = new IconListModel();
            $IconListModel->where('icon_id', $id)->delete();
            if ($IconListModel->saveAll($icon_list)) {
                $this->success('更新成功');
            } else {
                $this->error('图标添加失败');
            }
        }
        $this->success('更新成功');
    }

    /**
     * 删除图标库
     * @param string $ids
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author 蔡伟明 <314013107@qq.com>
     */
    public function delete($ids = '')
    {
        $ids == '' && $this->error('请选择要删除的数据');
        $ids = (array)$ids;

        // 删除图标列表
        if (false !== IconListModel::where('icon_id', 'in', $ids)->delete()) {
            // 删除图标库
            if (false !== IconModel::where('id', 'in', $ids)->delete()) {
                $this->success('删除成功');
            }
        }
        $this->error('删除失败');
    }
}
