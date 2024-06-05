<?php

namespace app\common\amis\build;

use Exception;
use think\facade\View;

class AmisForm
{
	protected $InitData = null;
	protected $page;

	protected $data;

	protected $title;

	protected $Form;
	protected $api;

	public function __construct()
	{
		$this->page = amisMake()->page();
		$this->Form = amisMake()->Form();
	}

	public function title()
	{
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

	/**
	 * 加载模板输出
	 * @param string $template 模板文件名
	 * @param array  $vars     模板输出变量
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function fetch($template = '', $vars = [])
	{
		$this->page->body(
			amisMake()->Form()
				->title()
				->mode('horizontal')
				->body([
					amisMake()->TextControl()->label('姓名')->name('username'),
				])
				->actions([
					amisMake()->Button()->label('提交')->actionType('ajax')->api((string)url(''))
				])
		);
		if ($template == '') {
			$template = __DIR__ . DIRECTORY_SEPARATOR . 'layout.html';
		}
		// dump(json_decode($jsonpage,true));die;
		View::assign('jsonpage', $this->page->toJson());
		return View::fetch($template, $vars);
	}
}
