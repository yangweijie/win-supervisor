<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\admin\controller\Admin;
use app\admin\model\Download as ModelDownload;
use app\common\job\DownloadJob;
use app\common\builder\ZBuilder;
use app\caring\model\CaringPairedPerson;
use app\common\logic\Download as LogicDownload;
use think\facade\Db;
use think\facade\Queue;

/**
 * 下载管理
 * @package app\caring\admin
 */
class Download extends Admin
{

	/**
	 * 初始化
	 * @author 蔡伟明 <314013107@qq.com>
	 * @throws \think\Exception
	 */
	protected function initialize()
	{
		parent::initialize();
		//检查并删除过期文件
		LogicDownload::deleteOutTimeFile();
	}


	/**
	 * 被帮扶对象监护人列表
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 * @throws \think\Exception
	 * @throws \think\exception\DbException
	 */
	public function index()
	{
		// 查询
		$map = $this->getMap();
		// 排序
		$order = $this->getOrder('update_time desc');
		// 数据列表
		$data_list = ModelDownload::where($map)->order($order)->paginate();

		// 使用ZBuilder快速创建数据表格
		return ZBuilder::make('table')

			->setSearch(['module' => '应用', 'title', '标题']) // 设置搜索框
			->addColumns([ // 批量添加数据列
				['id', 'ID'],
				['module', '应用', 'text'],
				['title', '标题', 'text'],
				['url', '下载', 'callback', function ($value) {
					return $value ? "<a href='" . $value . "'>下载</a>" : '<image src="/static/libs/layer/skin/default/loading-2.gif">';
				}],
				['status', '状态', 'status', '', ['失败', '成功', '下载中']],
				['create_time', '创建时间', 'datetime'],
				['update_time', '更新时间', 'datetime'],
				['right_button', '操作', 'btn']

			])
			->addTopButton('hospital', [
				'title' => '刷新',
				'icon'  => 'fa fa-fw fa-refresh',
				'href'  => (string)url('index')
			])
			->addRightButton('delete')
			->addOrder('id,module,title')
			->css('//unpkg.com/layui@2.7.6/dist/css/layui.css')
			->js('//unpkg.com/layui@2.7.6/dist/layui.js')
			->setRowList($data_list) // 设置表格数据
			->fetch(); // 渲染模板
	}


	/**
	 * 新增下载
	 * 
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 * @throws \think\Exception
	 */
	public function add()
	{
		$data =	request()->param();
		// 验证
		$result = $this->validate($data, basename(__CLASS__));
		if (true !== $result) $this->error($result);

		if ($create = ModelDownload::create($data)) {

			$module	= request()->param('module');
			$title	= request()->param('title');
			$method	= request()->param('method');
			$domain = request()->domain();
			$data = [
				'id'		=> $create->id,
				'sql'		=> deSql($data['sql']),
				'module'	=> $module,
				'title'		=> $title,
				'domain'	=> $domain,
				'method'	=> $method,
			];
			if (Queue::push(DownloadJob::class, $data)) {
				$this->success('数据正在导出，请稍后下载！');
			} else {
				$this->error('导出失败，请联系管理员！');
			}
		} else {
			$this->error('导出失败了，请联系管理员！');
		}
	}

	/**
	 * 删除友情链接
	 * @param array $record 行为日志
	 * @author 蔡伟明 <314013107@qq.com>
	 * @throws \think\Exception
	 * @throws \think\exception\PDOException
	 */
	public function delete($record = [])
	{
		$download = ModelDownload::whereIn('id', request()->param('ids'))->find();
		if ($download) {
			//替换URL中的域名	
			$file = str_replace(config('app.app_host'), '', $download['url']);
			$file_path = root_path() . 'public' . DIRECTORY_SEPARATOR . $file;
			 
			//判断文件是否存在，存在则删除
			if (file_exists($file_path)) {
				@unlink($file_path);
			}
			//删除数据库记录
			ModelDownload::where(['id' => $download['id']])->delete();
		}
	}
}
