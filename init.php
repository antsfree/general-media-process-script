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

// 提取 ffmpeg 及 ffprobe
$ret = get_command_result('which ffmpeg ffprobe');
if (count($ret) != 2) die("未找到对应可执行程序!\n");
list($ffmpeg_binaries, $ffprobe_binaries) = $ret;

// 初始化 FFMpeg
$ffmpeg = FFMpeg\FFMpeg::create([
    'ffmpeg.binaries'  => $ffmpeg_binaries ?: '/usr/local/bin/ffmpeg',
    'ffprobe.binaries' => $ffprobe_binaries ?: 'usr/local/bin/ffprobe',
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
]);

// 初始化 FFProbe
$ffprobe = FFMpeg\FFProbe::create();