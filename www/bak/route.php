<?php

// 对url进行解析，并获取请求的文件名
$uri = urldecode(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

// 判断文件是否存在，不存在返回false
if ($uri !== "/" && file_exists(__DIR__ . "$uri")) {
    return false;
}

function get_php_exe()
{
    if (
        defined('PHP_BINARY') &&
        PHP_BINARY &&
        in_array(PHP_SAPI, array('cli', 'cli-server')) &&
        is_file(PHP_BINARY)
    ) {
        return PHP_BINARY;
    } else if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $paths = explode(PATH_SEPARATOR, getenv('PATH'));
        foreach ($paths as $path) {
            if (substr($path, strlen($path) - 1) == DIRECTORY_SEPARATOR) {
                $path = substr($path, 0, strlen($path) - 1);
            }
            if (substr($path, strlen($path) - strlen('php')) == 'php') {
                $response = $path . DIRECTORY_SEPARATOR . 'php.exe';
                if (is_file($response)) {
                    return $response;
                }
            } else if (substr($path, strlen($path) - strlen('php.exe')) == 'php.exe') {
                if (is_file($response)) {
                    return $response;
                }
            }
        }
    } else {
        $paths = explode(PATH_SEPARATOR, getenv('PATH'));
        foreach ($paths as $path) {
            if (substr($path, strlen($path) - 1) == DIRECTORY_SEPARATOR) {
                $path = substr($path, strlen($path) - 1);
            }
            if (substr($path, strlen($path) - strlen('php')) == 'php') {
                if (is_file($path)) {
                    return $path;
                }
                $response = $path . DIRECTORY_SEPARATOR . 'php';
                if (is_file($response)) {
                    return $response;
                }
            }
        }
    }
    return null;
}

function shutdown()
{
    // 这是关闭函数，在脚本完成前可以进行任何最后的操作。

    file_put_contents('./close.log', 'closed');
}

register_shutdown_function('shutdown');
$php_bin = get_php_exe();
$cmd_file = realpath(__DIR__.'/cmd.php');
$file = __DIR__.'/log.log';
if(is_file($file))
    unlink($file);
$commandString = 'start /b '.$php_bin. ' '.$cmd_file;

// $commandString = $php_bin. ' '.$cmd_file;
// var_dump($commandString);

pclose(popen($commandString, 'r'));

// 加载入口文件
require_once "index.php";

