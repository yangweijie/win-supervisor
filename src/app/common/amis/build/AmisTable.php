<?php

namespace app\common\amis\build;

use Exception;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

class AmisTable
{

	protected $page;

	protected $data;

	protected $title;

	protected $CRUDTable;
	protected $api;
	/**
	 * 表头设置
	 */
	protected $CRUDTableHeader = [
		[
			"type" => "columns-toggler",
			"draggable" => true,
			// "overlay" => true,
		],
		"reload",
		[
			"type" =>  "tpl",
			"tpl" =>  '一共有${total}条数据',
			"align" => "right",
		],

	];
	/**
	 * 表页脚设置
	 */
	protected $CRUDTableFooter = [
		"switch-per-page",
		"pagination"
	];

	/**
	 * 是否同步请求表数据
	 */
	protected $syncLocation = false;

	/**
	 * 是否固定表头；
	 */
	protected $affixHeader = true;

	protected $rightButton = [];

	protected $columns = [];

	protected $InitData = null;

	protected $pageSeting = [
		"pageNo" => '${current_page}',
		"pageSize" => '${per_page}',
	];

	public function __construct()
	{
		$this->page = amisMake()->page();
		$this->CRUDTable = amisMake()->CRUDTable();
	}


	public function header($header = [])
	{
		$this->CRUDTableHeader = $header;
		return $this;
	}

	public function footer($footer = [])
	{
		$this->CRUDTableFooter = $footer;
		return $this;
	}

	public function api($url = '', $method = 'get', $headers = '')
	{
		$url = ($url == '') ? (string)url('') : $url;
		$this->api = amisMake()->BaseApi()->method($method)->url($url)->headers($headers);
		return $this;
	}

	public function title($title = '')
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * 设置请求数据闭包，所有前端数据在闭包中实现
	 */
	public function InitData($dataFun, $debug = false)
	{
		if (is_callable($dataFun)) {
			$this->InitData = $dataFun;
		}
		return $this;
	}

	public function columns($columns)
	{
		$this->columns = $columns;
		return $this;
	}

	/**
	 * 列右侧按钮
	 * string $fixed 可选值left right ''
	 */
	public function rightButton($buttons = [], $lable = '操作', $fixed = 'right')
	{
		$this->rightButton = amisMake()->Operation()->label($lable)->fixed($fixed)->buttons($buttons);
		return $this;
	}
	public function columns_delete($label = '删除', $actionType = 'ajax', $level = 'danger', $confirmText = '确认要删除吗？')
	{
		return amisMake()->Button()->label($label)->actionType($actionType)->level($level)->confirmText($confirmText)->api('delete:' . (string)url('delete', ['id' => '']) . '${id}');
	}

	/**
	 * 加载模板输出
	 * @param string $template 模板文件名
	 * @param array  $vars     模板输出变量
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function fetch($template = '', $vars = [])
	{
		if ($template == '') {
			$template = __DIR__ . DIRECTORY_SEPARATOR . 'layout.html';
		}
		if ($this->rightButton !== []) {
			$this->columns[] = $this->rightButton;
		}
		if ($this->api !== '') {
			$this->api = (string)url();
		}
		if (Request::isJson()) {
			$data = $this->InitData;
			$data = $data();

			if ($data) {
				$data =	['status' => 0, 'msg' => 'ok', 'data' => $data,];
			} else {
				$data =	['status' => 404, 'msg' => '返回数据错误', 'data' => $data,];
			}

			return json($data);
		}
		$this->page->title($this->title)
			->body(
				$this->CRUDTable->api($this->api)
					->data($this->pageSeting)
					->affixHeader(true)
					->syncLocation(false)
					->headerToolbar($this->CRUDTableHeader)
					->footerToolbar($this->CRUDTableFooter)
					->columns($this->columns)
			);

		// dump(json_decode($jsonpage,true));die;
		View::assign('jsonpage', $this->page->toJson());
		return View::fetch($template, $vars);
	}
}
