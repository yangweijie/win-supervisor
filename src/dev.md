# 后台目标

## 复用资源

# 常用命令

## build app

```php think build demo```

# 变化

## 配置 无法设置二级配置只能批量设全部

## 钩子=》行为

## module 为 app

## model 助手函数没有了

## Db::name 变为了Db:table

## helper 里hash arr类缺失

## $this->fetch 变为 View::fetch();

## application 目录变为app

## token 使用 要开启session
## token 函数不返回表单了 自己拼

## 后台移植过来时要做的处理

* think\Db => think\facade\Db;
* config('develop_mode') => config('app.develop_mode')
* setField 取消了 改为update
* base_path() => base_path()
* $this->assign => View::assign
* column('true', 'id' 等字段) => column('\*', 'id' 等字段)
* column(true) => column(true, 'id')
* Env::get('root_path') => root_path()


## 容易犯的错误

* 获取数据后 不判断是否为空 就 foreach 遍历


## 发现的bug

门户模块 里 文档无法删除

## 最新更改
* 升级框架为thinkphp 8
* 以tp8的开发规范修复升级问题，但还存在一些小问题；待修复！
* 原来的index.php和adminn.php 增加了 api.php;
* 系统修改了多应用包为内置包，在common目录内，无需再重新安装
* 文件上传改为了FileSystem组件，默认支持local存储；
* 内置FileSystem插件，启用插件可以配置腾讯、阿里云、七牛云、sftp、ftp、local方式,可按插件自行增加组件
* 插件增加了 save_plugin_config 钩子
* 注释了安装应用时复制静态文件后删除静态资源目录