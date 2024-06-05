<?php

namespace app\common\amis\Traits;

use app\common\amis\Renderers\Page;
use app\common\amis\Renderers\Form;
use app\common\amis\Renderers\Button;
use app\common\amis\Renderers\Dialog;
use app\common\amis\Renderers\CRUDTable;
use app\common\amis\Renderers\Operation;
use app\common\amis\Renderers\LinkAction;
use app\common\amis\Renderers\AjaxAction;
use app\common\amis\Renderers\OtherAction;
use app\common\amis\Renderers\DialogAction;

trait ElementTrait
{
    /**
     * 基础页面
     *
     * @return Page
     */
    protected function basePage(): Page
    {
        return Page::make()->className('m:overflow-auto');
    }

    /**
     * 返回列表按钮
     *
     * @return OtherAction|null
     */
    protected function backButton(): OtherAction|null
    {
        $path   = request()->domain();
        $script =
            sprintf('window.$owl.hasOwnProperty(\'closeTabByPath\') && window.$owl.closeTabByPath(\'%s\')', $path);

        return OtherAction::make()
            ->label(lang('back'))
            ->icon('fa-solid fa-chevron-left')
            ->level('primary')
            ->onClick('window.history.back();' . $script);
    }

    /**
     * 批量删除按钮
     *
     * @return AjaxAction
     */
    protected function bulkDeleteButton(): AjaxAction
    {
        return AjaxAction::make()
            ->api($this->getBulkDeletePath())
            ->icon('fa-solid fa-trash-can')
            ->label(lang('delete'))
            ->confirmText(lang('confirm_delete'));
    }

    /**
     * 新增按钮
     *
     * @param bool   $dialog
     * @param string $dialogSize
     *
     * @return DialogAction|LinkAction
     */
    protected function createButton(bool $dialog = false, string $dialogSize = ''): DialogAction|LinkAction
    {
        if ($dialog) {
            $form = $this->form(false)->api($this->getStorePath())->onEvent([]);

            $button = DialogAction::make()->dialog(
                Dialog::make()->title(lang('create'))->body($form)->size($dialogSize)
            );
        } else {
            $button = LinkAction::make()->link($this->getCreatePath());
        }

        return $button->label(lang('create'))->icon('fa fa-add')->level('primary');
    }

    /**
     * 行编辑按钮
     *
     * @param bool   $dialog
     * @param string $dialogSize
     *
     * @return DialogAction|LinkAction
     */
    protected function rowEditButton(bool $dialog = false, string $dialogSize = ''): DialogAction|LinkAction
    {
        if ($dialog) {
            $form = $this->form(true)
                ->api($this->getUpdatePath())
                ->initApi($this->getEditGetDataPath())
                ->redirect('')
                ->onEvent([]);

            $button = DialogAction::make()->dialog(
                Dialog::make()->title(lang('edit'))->body($form)->size($dialogSize)
            );
        } else {
            $button = LinkAction::make()->link($this->getEditPath());
        }

        return $button->label(lang('edit'))->icon('fa-regular fa-pen-to-square')->level('link');
    }

    /**
     * 行详情按钮
     *
     * @param bool   $dialog
     * @param string $dialogSize
     *
     * @return DialogAction|LinkAction
     */
    protected function rowShowButton(bool $dialog = false, string $dialogSize = ''): DialogAction|LinkAction
    {
        if ($dialog) {
            $button = DialogAction::make()->dialog(
                Dialog::make()->title(lang('show'))->body($this->detail('$id'))->size($dialogSize)
            );
        } else {
            $button = LinkAction::make()->link($this->getShowPath());
        }

        return $button->label(lang('show'))->icon('fa-regular fa-eye')->level('link');
    }

    /**
     * 行删除按钮
     *
     * @return AjaxAction
     */
    protected function rowDeleteButton(): AjaxAction
    {
        return AjaxAction::make()
            ->label(lang('delete'))
            ->icon('fa-regular fa-trash-can')
            ->level('link')
            ->confirmText(lang('confirm_delete'))
            ->api($this->getDeletePath());
    }

    /**
     * 操作列
     *
     * @param bool   $dialog
     * @param string $dialogSize
     *
     * @return Operation
     */
    protected function rowActions(bool|array $dialog = false, string $dialogSize = ''): Operation
    {
        if (is_array($dialog)) {
            return Operation::make()->label(lang('actions'))->buttons($dialog);
        }

        return Operation::make()->label(lang('actions'))->buttons([
            $this->rowShowButton($dialog, $dialogSize),
            $this->rowEditButton($dialog, $dialogSize),
            $this->rowDeleteButton(),
        ]);
    }

    /**
     * 基础筛选器
     *
     * @return Form
     */
    protected function baseFilter(): Form
    {
        return Form::make()
            ->panelClassName('base-filter')
            ->title('')
            ->actions([
                Button::make()->label(lang('reset'))->actionType('clear-and-submit'),
                amis('submit')->label(lang('search'))->level('primary'),
            ]);
    }

    /**
     * @return CRUDTable
     */
    protected function baseCRUD(): CRUDTable
    {
        return CRUDTable::make()
            ->perPage(20)
            ->affixHeader(false)
            ->filterTogglable()
            ->filterDefaultVisible(false)
            ->set('primaryField', 'id')
            ->api($this->getListGetDataPath())
            ->quickSaveApi($this->getQuickEditPath())
            ->quickSaveItemApi($this->getQuickEditItemPath())
            ->bulkActions([$this->bulkDeleteButton()])
            ->perPageAvailable([10, 20, 30, 50, 100, 200])
            ->footerToolbar(['switch-per-page', 'statistics', 'pagination'])
            ->headerToolbar([
                $this->createButton(),
                ...$this->baseHeaderToolBar(),
            ]);
    }

    protected function baseHeaderToolBar()
    {
        return [
            'bulkActions',
            amis('reload')->align('right'),
            amis('filter-toggler')->align('right'),
        ];
    }

    /**
     * 基础表单
     *
     * @return Form
     */
    protected function baseForm(): Form
    {
        $path = request()->domain();

        return Form::make()->panelClassName('px-48 m:px-0')->title(' ')->mode('horizontal')->onEvent([
            'submitSucc' => [
                'actions' => [
                    ['actionType' => 'custom', 'script' => 'window.history.back()'],
                    [
                        'actionType' => 'custom',
                        'script'     => sprintf('window.$owl.hasOwnProperty(\'closeTabByPath\') && window.$owl.closeTabByPath(\'%s\')', $path),
                    ],
                ],
            ],
        ]);
    }

    /**
     * @return Form
     */
    protected function baseDetail(): Form
    {
        return Form::make()
            ->panelClassName('px-48 m:px-0')
            ->title(' ')
            ->mode('horizontal')
            ->actions([])
            ->initApi($this->getShowGetDataPath());
    }

    /**
     * 基础列表
     *
     * @param $crud
     *
     * @return Page
     */
    protected function baseList($crud): Page
    {
        return $this->basePage()->body($crud);
    }

    /**
     * 导出按钮
     *
     * @return \app\common\amis\Renderers\Alert|\app\common\amis\Renderers\DropdownButton
     */
    protected function exportAction($disableSelectedItem = false)
    {
        if (!class_exists('\Maatwebsite\Excel\Excel')) {
            return amisMake()
                ->Alert()
                ->level('warning')
                ->body(lang('export.please_install_laravel_excel'))
                ->showIcon()
                ->showCloseButton();
        }

        $primaryKey = $this->service->primaryKey();

        $downloadPath   = '/' . admin_url('_download_export', true);
        $exportPath     = $this->getExportPath();
        $pageNoData     = lang('export.page_no_data');
        $selectedNoData = lang('export.selected_rows_no_data');
        $event          = fn($script) => ['click' => ['actions' => [['actionType' => 'custom', 'script' => $script]]]];
        $doAction       = <<<JS
doAction([
    { actionType: "ajax", args: { api: { url: url.toString(), method: "get" } } },
    {
        actionType: "custom",
        expression: "\${event.data.responseResult.responseStatus === 0}",
        script: "window.open('{$downloadPath}?path='+event.data.responseResult.responseData.path)"
    }
])
JS;
        $buttons        = [
            amisMake()->VanillaAction()->label(lang('export.all'))->onEvent(
                $event(<<<JS
let data = event.data.__super.__super
let params = Object.keys(data).filter(key => key !== "page" && key !== "__super").reduce((obj, key) => {
    obj[key] = data[key];
    return obj;
}, {})
let url = new URL("{$exportPath}", window.location.origin)
Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))
{$doAction}
JS

                )
            ),
            amisMake()->VanillaAction()->label(lang('export.page'))->onEvent(
                $event(<<<JS
let ids = event.data.items.map(item => item.{$primaryKey})
if(ids.length === 0) { return doAction({ actionType: "toast", args: { msgType: "warning", msg: "{$pageNoData}" } }) }
let url = new URL("{$exportPath}", window.location.origin)
url.searchParams.append("_ids", ids.join(","))
{$doAction}
JS
                )
            ),
        ];

        if (!$disableSelectedItem) {
            $buttons[] = amisMake()->VanillaAction()->label(lang('export.selected_rows'))->onEvent(
                $event(<<<JS
let ids = event.data.selectedItems.map(item => item.{$primaryKey})
if(ids.length === 0) { return doAction({ actionType: "toast", args: { msgType: "warning", msg: "{$selectedNoData}" } }) }
let url = new URL("{$exportPath}", window.location.origin)
url.searchParams.append("_ids", ids.join(","))
{$doAction}
JS
                )
            );
        }

        return amisMake()
            ->DropdownButton()
            ->label(lang('export.title'))
            ->set('icon', 'fa-solid fa-download')
            ->buttons($buttons)
            ->align('right')
            ->closeOnClick();
    }
}
