<?php

namespace app\common\amis\Traits;

trait CheckActionTrait
{
    /**
     * 是否为列表数据请求
     *
     * @return bool
     */
    public function actionOfGetData()
    {
        return request()->get('_action') == 'getData';
    }

    /**
     * 是否为导出数据请求
     *
     * @return bool
     */
    public function actionOfExport()
    {
        return request()->get('_action') == 'export';
    }

    /**
     * 是否为快速编辑数据请求
     *
     * @return bool
     */
    public function actionOfQuickEdit()
    {
        return request()->get('_action') == 'quickEdit';
    }

    /**
     * 是否为快速编辑数据请求
     *
     * @return bool
     */
    public function actionOfQuickEditItem()
    {
        return request()->get('_action') == 'quickEditItem';
    }
}
