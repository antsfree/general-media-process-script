<?php
require_once './vendor/autoload.php';
require_once './function.php';

// 检测 PHP 环境
if (version_compare(PHP_VERSION, '5.3.0', '<')) die('require PHP > 5.3.0 !');

// 检测 ffmpeg 和 ffprobe 服务
$ret = get_command_result('ffmpeg --version');
if (!strpos($ret[0], 'version')) die('未安装 ffmpeg !');
$ret = get_command_result('ffprobe --version');
if (!strpos($ret[0], 'version')) die('未安装 ffprobe !');