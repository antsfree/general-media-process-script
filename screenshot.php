<?php
require "vendor/autoload.php";
require "./function.php";

// 原媒体文件地址
$source_dir = input("输入原视频地址(回车结束)：");
// 取视频信息
$ffprobe = FFMpeg\FFProbe::create();
try {
    $format = $ffprobe->format($source_dir)->all();
} catch (Exception $exception) {
    $format = [];
}
if (!$format) die("媒体文件识别错误！");
print "视频总时长：" . $format['duration'] . "\n";
// 截取时间点
$time = input("输入截取的时间点，单位秒(回车结束)：");
if ($time > $format['duration']) die('非法截取时长参数值');
// 截图另存为
$shot_pic = input("截图保存名：");
// 截图处理
$ret = get_command_result('which ffmpeg ffprobe');
if (count($ret) != 2) die("未找到对应可执行程序!\n");
list($ffmpeg_binaries, $ffprobe_binaries) = $ret;
$ffmpeg = FFMpeg\FFMpeg::create([
    'ffmpeg.binaries'  => $ffmpeg_binaries,
    'ffprobe.binaries' => $ffprobe_binaries,
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
]);

$video     = $ffmpeg->open($source_dir);
$time_code = FFMpeg\Coordinate\TimeCode::fromSeconds($time);
$frame     = $video->frame($time_code);
$shot_file = dirname($source_dir) . '/' . $shot_pic;
$frame->save($shot_file);

die("图片截取成功：" . $shot_file);