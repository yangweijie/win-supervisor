<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\common\builder\form;

use app\common\builder\ZBuilder;
use think\Exception;
use think\facade\Env;
use think\facade\Event;
use think\facade\View;

/**
 * 表单构建器
 * @package app\common\builder\type
 * @author 蔡伟明 <314013107@qq.com>
 */
class FormBuilder extends ZBuilder
{
	/**
	 * @var string 模板路径
	 */
	private $_template = '';



	/**
	 * @var bool 是否组合分组
	 */
	private $_is_group = false;

	/**
	 * 初始化
	 * @author 蔡伟明 <314013107@qq.com>
	 */
	public function initialize()
	{
		$this->_template = root_path() . 'app/common/builder/form/layout.html';
	}

	/**
	 * 模板变量赋值
	 * @param mixed $name 要显示的模板变量
	 * @param string $value 变量的值
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function assign($name, $value = '')
	{
		if (is_array($name)) {
		} else {
		}
		return $this;
	}

	/**
	 * 设置页面标题
	 * @param string $title 页面标题
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setPageTitle($title = '')
	{
		if ($title != '') {
		}
		return $this;
	}

	/**
	 * 设置表单页提示信息
	 * @param string $tips 提示信息
	 * @param string $type 提示类型：success,info,danger,warning
	 * @param string $pos 提示位置：top,button
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setPageTips($tips = '', $type = 'info', $pos = 'top')
	{
		if ($tips != '') {
		}
		return $this;
	}

	/**
	 * 设置表单提交地址
	 * @param string $post_url 提交地址
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setUrl($post_url = '')
	{
		if ($post_url != '') {
		}
		return $this;
	}

	/**
	 * 隐藏按钮
	 * @param array|string $btn 要隐藏的按钮，如：['submit']，其中'submit'->确认按钮，'back'->返回按钮
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function hideBtn($btn = [])
	{
		if (!empty($btn)) {
		}
		return $this;
	}

	/**
	 * 添加底部额外按钮
	 * @param string $btn 按钮内容
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function addBtn($btn = '')
	{
		if ($btn != '') {
		}
		return $this;
	}

	/**
	 * 设置按钮标题
	 * @param string|array $btn 按钮名 'submit' -> “提交”，'back' -> “返回”
	 * @param string $title 按钮标题
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setBtnTitle($btn = '', $title = '')
	{
		if (!empty($btn)) {
			if (is_array($btn)) {
			} else {
			}
		}
		return $this;
	}

	/**
	 * 设置提交表单时显示确认框
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function submitConfirm()
	{

		return $this;
	}

	/**
	 * 隐藏表单头部标题
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function hideHeaderTitle()
	{

		return $this;
	}

	/**
	 * 设置表单头部标题
	 * @param string $title 标题
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setHeaderTitle($title = '')
	{

		return $this;
	}

	/**
	 * 设置表单令牌
	 * @param string $name 令牌名称
	 * @param string $type 令牌生成方法
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setToken($name = '__token__', $type = 'md5')
	{

		return $this;
	}

	/**
	 * 设置触发
	 * @param string $trigger 需要触发的表单项名，目前支持select（单选类型）、text、radio三种
	 * @param string $values 触发的值
	 * @param string $show 触发后要显示的表单项名，目前不支持普通联动、范围、拖动排序、静态文本
	 * @param bool $clear 是否清除值
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setTrigger($trigger = '', $values = '', $show = '', $clear = true)
	{
		if (!empty($trigger)) {
		}
		return $this;
	}

	/**
	 * 添加触发
	 * @param array $triggers 触发数组
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function addTrigger($triggers = [])
	{
		if (!empty($triggers)) {
			$this->setTrigger($triggers);
		}
		return $this;
	}

	/**
	 * 添加数组类型的表单项，基本和Textarea是一样的，但读取的时候会用parse_attr函数转换
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author caiweiming <314013107@qq.com>
	 * @return Builder
	 */
	public function addArray($name = '', $title = '', $tips = '', $default = '', $extra_attr = '', $extra_class = '')
	{
		return $this->addTextarea($name, $title, $tips, $default, $extra_attr, $extra_class);
	}

	/**
	 * 添加单个档案文件
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addArchive($name = '', $title = '', $tips = '', $extra_class = '')
	{
		$item = [
			'type'        => 'archive',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加多个档案文件
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addArchives($name = '', $title = '', $tips = '', $extra_class = '')
	{
		$item = [
			'type'        => 'archives',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加百度地图
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $ak 百度APPKEY
	 * @param string $tips 提示
	 * @param string $default 默认坐标
	 * @param string $address 默认地址
	 * @param string $level 地图显示级别
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addBmap($name = '', $title = '', $ak = '', $tips = '', $default = '', $address = '', $level = '', $extra_class = '')
	{
		$item = [
			'type'        => 'bmap',
			'name'        => $name,
			'title'       => $title,
			'ak'          => $ak,
			'tips'        => $tips,
			'value'       => $default,
			'address'     => $address,
			'level'       => $level == '' ? 12 : $level,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加按钮
	 * @param string $name 表单项名，也是按钮id
	 * @param array $attr 按钮属性
	 * @param string $ele_type 按钮类型，默认为button，也可以为a标签
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this|array
	 */
	public function addButton($name = '', $attr = [], $ele_type = 'button')
	{
		$item = [
			'type'     => 'button',
			'name'     => $name,
			'id'       => $name,
			'ele_type' => $ele_type,
			'data'     => '',
		];
		if ($attr) {
			foreach ($attr as $key => $value) {
				if (substr($key, 0, 5) == 'data-') {
					$item['data'] .= $key . '=' . $value . ' ';
				}
			}
			$item = array_merge($item, $attr);
		}

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加复选框
	 * @param string $name 复选框名
	 * @param string $title 复选框标题
	 * @param string $tips 提示
	 * @param array $options 复选框数据
	 * @param string $default 默认值
	 * @param array $attr 属性，
	 *      color-颜色(default/primary/info/success/warning/danger)，默认primary
	 *      size-尺寸(sm,nm,lg)，默认sm
	 *      shape-形状(rounded,square)，默认rounded
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addCheckbox($name = '', $title = '', $tips = '', $options = [], $default = '', $attr = [], $extra_attr = '', $extra_class = '')
	{
		$item = [
			'type'        => 'checkbox',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'options'     => $options == '' ? [] : $options,
			'value'       => $default,
			'attr'        => $attr,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
			'extra_label_class' => $extra_attr == 'disabled' ? 'css-input-disabled' : '',
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加CKEditor编辑器
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $width 编辑器宽度，默认100%
	 * @param integer $height 编辑器高度，默认400px
	 * @param string $default 默认值
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addCkeditor($name = '', $title = '', $tips = '', $default = '', $width = '100%', $height = 400, $extra_class = '')
	{
		$item = [
			'type'        => 'ckeditor',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'width'       => $width,
			'height'      => $height,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加取色器
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $mode 模式：默认为rgba(含透明度)，也可以是rgb
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addColorpicker($name = '', $title = '', $tips = '', $default = '', $mode = 'rgba', $extra_attr = '', $extra_class = '')
	{
		$item = [
			'type'        => 'colorpicker',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'mode'        => $mode,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加日期
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $format 日期格式
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addDate($name = '', $title = '', $tips = '', $default = '', $format = '', $extra_attr = '', $extra_class = '')
	{
		$item = [
			'type'        => 'date',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'format'      => $format == '' ? 'yyyy-mm-dd' : $format,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加日期范围
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $format 格式
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addDaterange($name = '', $title = '', $tips = '', $default = '', $format = '', $extra_attr = '', $extra_class = '')
	{
		if (strpos($name, ',')) {
			list($name_from, $name_to) = explode(',', $name);
			$id_from = $name_from;
			$id_to   = $name_to;
			$id      = $name_from;
		} else {
			$name_from = $name_to = $name . '[]';
			$id_from = $name . '_from';
			$id_to   = $name . '_to';
			$id      = $name;
		}

		if (strpos($default, ',') !== false) {
			list($value_from, $value_to) = explode(',', $default);
		} else {
			$value_from = $default;
			$value_to   = '';
		}

		$item = [
			'type'        => 'daterange',
			'id'          => $id,
			'name_from'   => $name_from,
			'name_to'     => $name_to,
			'id_from'     => $id_from,
			'id_to'       => $id_to,
			'title'       => $title,
			'tips'        => $tips,
			'value_from'  => $value_from,
			'value_to'    => $value_to,
			'format'      => $format == '' ? 'yyyy-mm-dd' : $format,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加日期时间
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $format 日期时间格式
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addDatetime($name = '', $title = '', $tips = '', $default = '', $format = '', $extra_attr = '', $extra_class = '')
	{
		$item = [
			'type'        => 'datetime',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'format'      => $format == '' ? 'YYYY-MM-DD HH:mm' : $format,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加markdown编辑器
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param bool $watch 是否实时预览
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addEditormd($name = '', $title = '', $tips = '', $default = '', $watch = true, $extra_class = '')
	{
		$item = [
			'type'        => 'editormd',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'watch'       => $watch,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加单文件上传
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $size 文件大小，单位为kb
	 * @param string $ext 文件后缀
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addFile($name = '', $title = '', $tips = '', $default = '', $size = '', $ext = '', $extra_class = '')
	{
		$size = ($size != '' ? $size : config('app.upload_file_size')) * 1024;
		$ext  = $ext != '' ? $ext : config('app.upload_file_ext');

		$item = [
			'type'        => 'file',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'size'        => $size,
			'ext'         => $ext,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加多文件上传
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $size 图片大小，单位为kb
	 * @param string $ext 文件后缀
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addFiles($name = '', $title = '', $tips = '', $default = '', $size = '', $ext = '', $extra_class = '')
	{
		$size = ($size != '' ? $size : config('app.upload_file_size')) * 1024;
		$ext  = $ext != '' ? $ext : config('app.upload_file_ext');

		$item = [
			'type'        => 'files',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'size'        => $size,
			'ext'         => $ext,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加图片相册
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addGallery($name = '', $title = '', $tips = '', $default = '', $extra_class = '')
	{
		$item = [
			'type'        => 'gallery',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加分组
	 * @param array $groups 分组数据
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addGroup($groups = [])
	{
		if (is_array($groups) && !empty($groups)) {
			$this->_is_group = true;
			foreach ($groups as &$group) {
				foreach ($group as $key => $item) {
					$type = array_shift($item);
					if (strpos($type, ':')) {
						list($type, $layout) = explode(':', $type);

						$layout = explode('|', $layout);
						[
							'xs' => $layout[0],
							'sm' => isset($layout[1]) ? ($layout[1] == '' ? $layout[0] : $layout[1]) : $layout[0],
							'md' => isset($layout[2]) ? ($layout[2] == '' ? $layout[0] : $layout[2]) : $layout[0],
							'lg' => isset($layout[3]) ? ($layout[3] == '' ? $layout[0] : $layout[3]) : $layout[0],
						];
					}
					$group[$key] = call_user_func_array([$this, 'add' . ucfirst($type)], $item);
				}
			}
			$this->_is_group = false;
		}

		$item = [
			'type'    => 'group',
			'options' => $groups
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加隐藏表单项
	 * @param string $name 表单项名
	 * @param string $default 默认值
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addHidden($name = '', $default = '', $extra_class = '')
	{
		$item = [
			'type'        => 'hidden',
			'name'        => $name,
			'value'       => $default,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加图标选择器
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addIcon($name = '', $title = '', $tips = '', $default = '', $extra_attr = '', $extra_class = '')
	{
		$item = [
			'type'        => 'icon',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加单图片上传
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $size 图片大小，单位为kb，0为不限制
	 * @param string $ext 文件后缀
	 * @param string $extra_class 额外css类名
	 * @param array|string $thumb 缩略图参数
	 * @param array|string $watermark 水印参数
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addImage($name = '', $title = '', $tips = '', $default = '', $size = '', $ext = '', $extra_class = '', $thumb = '', $watermark = '')
	{
		$size = ($size != '' ? $size : config('app.upload_image_size')) * 1024;
		$ext  = $ext != '' ? $ext : config('app.upload_image_ext');

		$item = [
			'type'        => 'image',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'size'        => $size,
			'ext'         => $ext,
			'extra_class' => $extra_class,
		];

		// 处理缩略图参数
		if (isset($thumb['size'])) {
			$item['thumb'] = $thumb['size'] . '|' . (isset($thumb['type']) ? $thumb['type'] : 1);
		} else {
			$item['thumb'] = $thumb;
		}

		// 处理水印参数
		if (isset($watermark['img'])) {
			$item['watermark'] = $watermark['img'] . '|' . (isset($watermark['pos']) ? $watermark['pos'] : 9) . '|' . (isset($watermark['alpha']) ? $watermark['alpha'] : 50);
		} else {
			$item['watermark'] = $watermark;
		}

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加多图片上传
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $size 图片大小，单位为kb，0为不限制
	 * @param string $ext 文件后缀
	 * @param string $extra_class 额外css类名
	 * @param array|string $thumb 缩略图参数
	 * @param array|string $watermark 水印参数
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addImages($name = '', $title = '', $tips = '', $default = '', $size = '', $ext = '', $extra_class = '', $thumb = '', $watermark = '')
	{
		$size = ($size != '' ? $size : config('app.upload_image_size')) * 1024;
		$ext  = $ext != '' ? $ext : config('app.upload_image_ext');

		$item = [
			'type'        => 'images',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'size'        => $size,
			'ext'         => $ext,
			'extra_class' => $extra_class,
		];

		// 处理缩略图参数
		if (isset($thumb['size'])) {
			$item['thumb'] = $thumb['size'] . '|' . (isset($thumb['type']) ? $thumb['type'] : 1);
		} else {
			$item['thumb'] = $thumb;
		}

		// 处理水印参数
		if (isset($watermark['img'])) {
			$item['watermark'] = $watermark['img'] . '|' . (isset($watermark['pos']) ? $watermark['pos'] : 9) . '|' . (isset($watermark['alpha']) ? $watermark['alpha'] : 50);
		} else {
			$item['watermark'] = $watermark;
		}

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 图片裁剪
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param array $options 参数
	 * @param string $extra_class 额外css类名
	 * @param array|string $thumb 缩略图参数
	 * @param array|string $watermark 水印参数
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addJcrop($name = '', $title = '', $tips = '', $default = '', $options = [], $extra_class = '', $thumb = '', $watermark = '')
	{
		$item = [
			'type'        => 'jcrop',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'options'     => json_encode($options),
			'extra_class' => $extra_class,
		];

		// 处理缩略图参数
		if (isset($thumb['size'])) {
			$item['thumb'] = $thumb['size'] . '|' . (isset($thumb['type']) ? $thumb['type'] : 1);
		} else {
			$item['thumb'] = $thumb;
		}

		// 处理水印参数
		if (isset($watermark['img'])) {
			$item['watermark'] = $watermark['img'] . '|' . (isset($watermark['pos']) ? $watermark['pos'] : 9) . '|' . (isset($watermark['alpha']) ? $watermark['alpha'] : 50);
		} else {
			$item['watermark'] = $watermark;
		}

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加普通联动表单项
	 * @param string $name 表单项名
	 * @param string $title 表单项标题
	 * @param string $tips 表单项提示说明
	 * @param array $options 表单项options
	 * @param string $default 默认值
	 * @param string $ajax_url 数据异步请求地址
	 *      可以用Url方法生成，返回数据格式必须如下：
	 *      $arr['code'] = '1'; //判断状态
	 *      $arr['msg'] = '请求成功'; //回传信息
	 *      $arr['list'] = [
	 *          ['key' => 'gz', 'value' => '广州'],
	 *          ['key' => 'sz', 'value' => '深圳'],
	 *      ]; //数据
	 *      return json($arr);
	 *      status用于判断是否请求成功，list将作为$next_items第一个表单名的下拉框的内容
	 * @param string $next_items 下一级下拉框的表单名
	 *      如果有多个关联关系，必须一同写上，用逗号隔开,
	 *      比如学院作为联动的一个下拉框，它的下级是专业，那么这里就写上专业下拉框的表单名，如：'zy'
	 *      如果还有班级，那么切换学院的时候，专业和班级应该是一同关联的
	 *      所以就必须写上专业和班级的下拉框表单名，如：'zy,bj'
	 * @param string $param 指定请求参数的key名称，默认为$name的值
	 *      比如$param为“key”
	 *      那么请求数据的时候会发送参数key=某个下拉框选项值
	 * @param string $extra_param 额外参数名，可以同时发送表单中的其他表单项值
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addLinkage($name = '', $title = '', $tips = '', $options = [], $default = '', $ajax_url = '', $next_items = '', $param = '', $extra_param = '')
	{
		$item = [
			'type'        => 'linkage',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'options'     => $options,
			'ajax_url'    => $ajax_url,
			'next_items'  => $next_items,
			'param'       => $param == '' ? $name : $param,
			'extra_param' => $extra_param,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}


	/**
	 * 添加快速多级联动
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $table 表名
	 * @param int $level 级别
	 * @param string $default 默认值
	 * @param array|string $fields 字段名，默认为id,name,pid
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addLinkages($name = '', $title = '', $tips = '', $table = '', $level = 2, $default = '', $fields = [])
	{
		if ($level > 5) {
			halt('目前最多只支持4级联动');
		}

		// 键字段名，也就是下拉菜单的option元素的value值
		$key    = 'id';
		// 值字段名，也就是下拉菜单显示的各项
		$option = 'name';
		// 父级id字段名
		$pid    = 'pid';
		$start_pid = 0;
		if (!empty($fields)) {
			if (!is_array($fields)) {
				$fields = explode(',', $fields);
				$key    	= isset($fields[0]) ? $fields[0] : $key;
				$option 	= isset($fields[1]) ? $fields[1] : $option;
				$pid    	= isset($fields[2]) ? $fields[2] : $pid;
				$start_pid  = isset($fields[3]) ? $fields[3] : $pid;
			} else {
				$key    	= isset($fields['id'])   ? $fields['id']   : $key;
				$option 	= isset($fields['name']) ? $fields['name'] : $option;
				$pid    	= isset($fields['pid'])  ? $fields['pid']  : $pid;
				$start_pid  = isset($fields['start_pid'])  ? $fields['start_pid']  : $pid;
			}
		}

		$linkages_token = $this->createLinkagesToken($table, $option, $key);

		$item = [
			'type'  	 => 'linkages',
			'name'   	=> $name,
			'title'  	=> $title,
			'tips'   	=> $tips,
			'table'  	=> $table,
			'level'  	=> $level,
			'key'    	=> $key,
			'option' 	=> $option,
			'pid'    	=> $pid,
			'start_pid'	=> $start_pid,
			'value'  	=> $default,
			'token'  	=> $linkages_token,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加格式文本
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $format 格式
	 * @param string $default 默认值
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addMasked($name = '', $title = '', $tips = '', $format = '', $default = '', $extra_attr = '', $extra_class = '')
	{
		$item = [
			'type'        => 'masked',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'format'      => $format,
			'value'       => $default,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加数字输入框
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $min 最小值
	 * @param string $max 最大值
	 * @param string $step 步进值
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addNumber($name = '', $title = '', $tips = '', $default = '', $min = '', $max = '', $step = '', $extra_attr = '', $extra_class = '')
	{
		if (preg_match('/(.*)\[:(.*)\]/', $title, $matches)) {
			$title       = $matches[1];
			$placeholder = $matches[2];
		}

		$item = [
			'type'        => 'number',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default == '' ? 0 : $default,
			'min'         => $min,
			'max'         => $max,
			'step'        => $step,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
			'placeholder' => isset($placeholder) ? $placeholder : '请输入' . $title,
		];

		if ($this->_is_group) {
			return $item;
		}


		return $this;
	}

	/**
	 * 添加密码框
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addPassword($name = '', $title = '', $tips = '', $default = '', $extra_attr = '', $extra_class = '')
	{
		if (preg_match('/(.*)\[:(.*)\]/', $title, $matches)) {
			$title       = $matches[1];
			$placeholder = $matches[2];
		}

		$item = [
			'type'        => 'password',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
			'placeholder' => isset($placeholder) ? $placeholder : '请输入' . $title,
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加单选
	 * @param string $name 单选名
	 * @param string $title 单选标题
	 * @param string $tips 提示
	 * @param array $options 单选数据
	 * @param string $default 默认值
	 * @param array $attr 属性，
	 *      color-颜色(default/primary/info/success/warning/danger)，默认primary
	 *      size-尺寸(sm,nm,lg)，默认sm
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addRadio($name = '', $title = '', $tips = '', $options = [], $default = '', $attr = [], $extra_attr = '', $extra_class = '')
	{
		$item = [
			'type'        => 'radio',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'options'     => $options == '' ? [] : $options,
			'value'       => $default,
			'attr'        => $attr,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
			'extra_label_class' => $extra_attr == 'disabled' ? 'css-input-disabled' : '',
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加范围
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param array $options 参数
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addRange($name = '', $title = '', $tips = '', $default = '', $options = [], $extra_attr = '', $extra_class = '')
	{
		$item = [
			'type'        => 'range',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
		];
		$item = array_merge($item, $options);
		if (isset($item['double']) && $item['double'] == 'true') {
			$item['double'] = 'double';
		}

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加普通下拉菜单
	 * @param string $name 下拉菜单名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param array $options 选项
	 * @param string $default 默认值
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addSelect($name = '', $title = '', $tips = '', $options = [], $default = '', $extra_attr = '', $extra_class = '')
	{

		$type = 'select';

		if ($extra_attr != '') {
			if (in_array('multiple', explode(' ', $extra_attr))) {
				$type = 'select2';
			}
		}

		$placeholder = $type == 'select' ? '请选择一项' : '请选择一项或多项';
		if (preg_match('/(.*)\[:(.*)\]/', $title, $matches)) {
			$title       = $matches[1];
			$placeholder = $matches[2];
		}

		$item = [
			'type'        => $type,
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'options'     => $options,
			'value'       => $default,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
			'placeholder' => $placeholder,
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加拖拽排序
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param array $value 值
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addSort($name = '', $title = '', $tips = '', $value = [], $extra_class = '')
	{
		$content = [];

		if (!empty($value)) {
			$content = $value;
		}

		$item = [
			'type'        => 'sort',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => implode(',', array_keys($value)),
			'content'     => $content,
			'extra_class' => $extra_class
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加静态文本
	 * @param string $name 静态表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $hidden 需要提交的值
	 * @param string $extra_class 额外css类
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addStatic($name = '', $title = '', $tips = '', $default = '', $hidden = '', $extra_class = '')
	{
		$item = [
			'type'        => 'static',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'hidden'      => $hidden === true ? ($default == '' ? true : $default) : $hidden,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加Summernote编辑器
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $width 编辑器宽度
	 * @param int $height 编辑器高度
	 * @param string $extra_class
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addSummernote($name = '', $title = '', $tips = '', $default = '', $width = '100%', $height = 350, $extra_class = '')
	{
		$item = [
			'type'        => 'summernote',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'width'       => $width,
			'height'      => $height,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加开关
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param array $attr 属性，
	 *      color-颜色(default/primary/info/success/warning/danger)，默认primary
	 *      size-尺寸(sm,nm,lg)，默认sm
	 *      shape-形状(rounded,square)，默认rounded
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addSwitch($name = '', $title = '', $tips = '', $default = '', $attr = [], $extra_attr = '', $extra_class = '')
	{
		$item = [
			'type'        => 'switch',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'attr'        => $attr,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
			'extra_label_class' => $extra_attr == 'disabled' ? 'css-input-disabled' : '',
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加标签
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addTags($name = '', $title = '', $tips = '', $default = '', $extra_class = '')
	{
		$item = [
			'type'        => 'tags',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => is_array($default) ? implode(',', $default) : $default,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加单行文本框
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param array $group 标签组，可以在文本框前后添加按钮或者文字
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addText($name = '', $title = '', $tips = '', $default = '', $group = [], $extra_attr = '', $extra_class = '')
	{
		if (preg_match('/(.*)\[:(.*)\]/', $title, $matches)) {
			$title       = $matches[1];
			$placeholder = $matches[2];
		}

		$item = [
			'type'        => 'text',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'group'       => $group,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
			'placeholder' => isset($placeholder) ? $placeholder : '请输入' . $title,
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加多行文本框
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addTextarea($name = '', $title = '', $tips = '', $default = '', $extra_attr = '', $extra_class = '')
	{
		if (preg_match('/(.*)\[:(.*)\]/', $title, $matches)) {
			$title       = $matches[1];
			$placeholder = $matches[2];
		}

		$item = [
			'type'        => 'textarea',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
			'placeholder' => isset($placeholder) ? $placeholder : '请输入' . $title,
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加时间
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $format 日期时间格式
	 * @param string $extra_attr 额外属性
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addTime($name = '', $title = '', $tips = '', $default = '', $format = '', $extra_attr = '', $extra_class = '')
	{
		$item = [
			'type'        => 'time',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'format'      => $format == '' ? 'HH:mm:ss' : $format,
			'extra_class' => $extra_class,
			'extra_attr'  => $extra_attr,
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加百度编辑器
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addUeditor($name = '', $title = '', $tips = '', $default = '', $extra_class = '')
	{
		$item = [
			'type'        => 'ueditor',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加wang编辑器
	 * @param string $name 表单项名
	 * @param string $title 标题
	 * @param string $tips 提示
	 * @param string $default 默认值
	 * @param string $extra_class 额外css类名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return mixed
	 */
	public function addWangeditor($name = '', $title = '', $tips = '', $default = '', $extra_class = '')
	{
		$item = [
			'type'        => 'wangeditor',
			'name'        => $name,
			'title'       => $title,
			'tips'        => $tips,
			'value'       => $default,
			'extra_class' => $extra_class,
		];

		if ($this->_is_group) {
			return $item;
		}

		return $this;
	}

	/**
	 * 添加表单项
	 * 这个是addCheckbox等方法的别名方法，第一个参数传表单项类型，其余参数与各自方法中的参数一致
	 * @param string $type 表单项类型
	 * @param string $name 表单项名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function addFormItem($type = '', $name = '')
	{
		if ($type != '') {
			// 获取所有参数值
			$args = func_get_args();
			array_shift($args);

			// 判断是否有布局参数
			if (strpos($type, ':')) {
				list($type, $layout) = explode(':', $type);

				$layout = explode('|', $layout);
				[
					'xs' => $layout[0],
					'sm' => isset($layout[1]) ? ($layout[1] == '' ? $layout[0] : $layout[1]) : $layout[0],
					'md' => isset($layout[2]) ? ($layout[2] == '' ? $layout[0] : $layout[2]) : $layout[0],
					'lg' => isset($layout[3]) ? ($layout[3] == '' ? $layout[0] : $layout[3]) : $layout[0],
				];
			}

			$method = 'add' . ucfirst($type);
			call_user_func_array([$this, $method], $args);
		}
		return $this;
	}

	/**
	 * 一次性添加多个表单项
	 * @param array $items 表单项
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function addFormItems($items = [])
	{
		if (!empty($items)) {
			foreach ($items as $item) {
				call_user_func_array([$this, 'addFormItem'], $item);
			}
		}
		return $this;
	}

	/**
	 * 直接设置表单项数据
	 * @param array $items 表单项数据
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setFormItems($items = [])
	{
		if (!empty($items)) {
			foreach ($items as $key =>  $item) {
				switch ($item['type']) {
					case 'group':
						foreach ($item['options'] as $options) {
							foreach ($options as $option) {
								$this->loadMinify($option['type']);
							}
						}
						break;
					case 'select':
						if (isset($item['extra_attr']) && $item['extra_attr'] == 'multiple') {
							$items[$key]['type'] = 'select2';
						}
						break;
				}
				if ($item['type'] == 'group') {
				} else {
					$this->loadMinify($item['type']);
				}

				// 设置布局参数
				if (isset($item['layout'])) {
					[
						'xs' => $item['layout'],
						'sm' => $item['layout'],
						'md' => $item['layout'],
						'lg' => $item['layout'],
					];
				}
			}

			// 额外已经构造好的表单项目与单个组装的的表单项目进行合并
		}
		return $this;
	}

	/**
	 * 扩展额外表单项
	 * @param $methodName
	 * @param $argument
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 * @throws Exception
	 */
	public function __call($methodName, $argument)
	{
		$type = strtolower(substr($methodName, 3));

		if ($type != '') {


			$plugin_form_items = Event::trigger($type, $argument);
		}
		return $this;
	}



	/**
	 * 设置Tab按钮列表
	 * @param array $tab_list Tab列表 如：['tab1' => ['title' => '标题', 'url' => 'http://www.dolphinphp.com']]
	 * @param string $curr_tab 当前tab名
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setTabNav($tab_list = [], $curr_tab = '')
	{
		if (!empty($tab_list)) {
			[
				'tab_list' => $tab_list,
				'curr_tab' => $curr_tab,
			];
		}
		return $this;
	}

	/**
	 * 设置表单数据
	 * @param array $form_data 表单数据
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setFormData($form_data = [])
	{
		if (!empty($form_data)) {
		}
		return $this;
	}

	/**
	 * 设置额外HTML代码
	 * @param string $extra_html 额外HTML代码
	 * @param string $tag 标记
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setExtraHtml($extra_html = '', $tag = '')
	{
		if ($extra_html != '') {
			$tag != '' && $tag = '_' . $tag;
		}
		return $this;
	}

	/**
	 * 设置额外JS代码
	 * @param string $extra_js 额外JS代码
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setExtraJs($extra_js = '')
	{
		if ($extra_js != '') {
		}
		return $this;
	}

	/**
	 * 设置额外CSS代码
	 * @param string $extra_css 额外CSS代码
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setExtraCss($extra_css = '')
	{
		if ($extra_css != '') {
		}
		return $this;
	}

	/**
	 * 表单项布局
	 * @param array $column 布局参数 ['表单项名' => 所占宽度,....]
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function layout($column = [])
	{
		if (!empty($column)) {
			foreach ($column as $field => $layout) {
				$layout = explode('|', $layout);
				[
					'xs' => $layout[0],
					'sm' => isset($layout[1]) ? ($layout[1] == '' ? $layout[0] : $layout[1]) : $layout[0],
					'md' => isset($layout[2]) ? ($layout[2] == '' ? $layout[0] : $layout[2]) : $layout[0],
					'lg' => isset($layout[3]) ? ($layout[3] == '' ? $layout[0] : $layout[3]) : $layout[0],
				];
			}
		}
		return $this;
	}

	/**
	 * 引入模块js文件
	 * @param string $files_name js文件名，多个文件用逗号隔开
	 * @param string $module 指定模块
	 * @author caiweiming <314013107@qq.com>
	 * @return $this
	 */
	public function js($files_name = '', $module = '')
	{
		if ($files_name != '') {
			$this->loadFile('js', $files_name, $module);
		}
		return $this;
	}

	/**
	 * 引入模块css文件
	 * @param string $files_name css文件名，多个文件用逗号隔开
	 * @param string $module 指定模块
	 * @author caiweiming <314013107@qq.com>
	 * @return $this
	 */
	public function css($files_name = '', $module = '')
	{
		if ($files_name != '') {
			$this->loadFile('css', $files_name, $module);
		}
		return $this;
	}

	/**
	 * 设置表单提交方式
	 * @param string $value 提交方式
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function method($value = '')
	{
		if ($value != '') {
		}
		return $this;
	}

	/**
	 * 引入css或js文件
	 * @param string $type 类型：css/js
	 * @param string $files_name 文件名，多个用逗号隔开
	 * @param string $module 指定模块
	 * @author caiweiming <314013107@qq.com>
	 */
	private function loadFile($type = '', $files_name = '', $module = '')
	{
		if ($files_name != '') {
			$module = $module == '' ? app()->http->getName() : $module;
			if (!is_array($files_name)) {
				$files_name = explode(',', $files_name);
			}
			foreach ($files_name as $item) {
				if (strpos($item, '/')) {
				} else {
				}
			}
		}
	}

	/**
	 * 设置ajax方式提交
	 * @param bool $ajax_submit 默认true，false为关闭ajax方式提交
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function isAjax($ajax_submit = true)
	{
		return $this;
	}

	/**
	 * 设置模版路径
	 * @param string $template 模板路径
	 * @author 蔡伟明 <314013107@qq.com>
	 * @return $this
	 */
	public function setTemplate($template = '')
	{
		if ($template != '') {
			$this->_template = $template;
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

		// dump($this->_vars);die;
		// 实例化视图并渲染
		return View::fetch($this->_template);
	}
}
