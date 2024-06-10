<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

/**
 * 插件配置信息
 */
return [
	[
		'group',
		[
			'本地' => [
				['hidden', 'local.type', 'local'],
				['text', 'local.root', '文件存储根目录', '文件存放地址', app()->getRootPath() . 'public/uploads'],
				['text', 'local.url', '外部URL', '磁盘路径对应的外部URL路径', '/uploads'],
				['text', 'local.visibility', 'visibility', '可见性', 'public'],
			],
			'阿里云OSS' => [
				['hidden', 'oss.type', 'oss'],
				['text', 'oss.credentials.accessId', 'accessId'],
				['text', 'oss.credentials.accessSecret', 'accessSecret'],
				['text', 'oss.bucket', 'bucket'],
				['text', 'oss.endpoint', 'endpoint'],
				['text', 'oss.url', 'url'],
			],
			'腾讯COS' => [
				['hidden', 'cos.type', 'cos'],
				['text', 'cos.region', 'region'],
				['text', 'cos.appId', 'appId'],
				['text', 'cos.secretId', 'secretId'],
				['text', 'cos.secretKey', 'secretKey'],
				['text', 'cos.bucket', 'bucket'],
				['text', 'cos.timeout', 'timeout', '', 60],
				['text', 'cos.connect_timeout', 'connect_timeout', '', 60],
				['text', 'cos.cdn', 'cdn', '您的 CDN 域名'],
				['text', 'cos.scheme', 'scheme', '', 'https'],
				['text', 'cos.read_from_cdn', 'read_from_cdn', '', 0],
				['text', 'cos.domain', 'domain', '访问域名'],
			],
			'七牛云' => [
				['hidden', 'qiniu.type', 'qiniu'],
				['text', 'qiniu.accessKey', 'accessKey'],
				['text', 'qiniu.secretKey', 'secretKey'],
				['text', 'qiniu.bucket', 'bucket'],
				['text', 'qiniu.domain', 'domain', '不要斜杠结尾,URL地址域名'],
			],
			'sftp' => [
				['hidden', 'sftp.type', 'sftp'],
				['text', 'sftp.host', '主机地址'],
				['text', 'sftp.port', 'ssh端口'],
				['text', 'sftp.username', '用户名'],
				['text', 'sftp.password', '密码'],
				['text', 'sftp.root', 'root', '文件存放地址', ''],
				['text', 'sftp.timeout', 'timeout', '超时时间', 10],
			],
			'ftp' => [
				['hidden', 'ftp.type', 'ftp'],
				['text', 'ftp.host', '主机地址'],
				['text', 'ftp.username', '用户名'],
				['text', 'ftp.password', '密码'],
				['text', 'ftp.root', '文件存储根目录', '文件存放地址', ''],
			],
		]
	]
];
