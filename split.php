<?php

require_once "init.php";

$source_dir = input('原媒体文件路径：');
// 取视频信息
try {
    $format = $ffprobe->format($source_dir)->all();
} catch (Exception $exception) {
    $format = [];
}
if (!$format) die("媒体文件识别出错！");
print "视频总时长：" . $format['duration'] . "\n";
// 开始时间点
$start_time = input("输入开始时间点，单位秒(回车结束)：");
// 结束时间点
$end_time = input("输入结束时间点，单位秒(回车结束)：");
// 保存路径
$target_dir = input("拆分后文件存储地址："); // 目标文件
if ($start_time >= $end_time) die("时间参数错误\n");

$duration = $end_time - $start_time;
// 视频处理
$video = $ffmpeg->open($source_dir);
$video->filters()->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds($start_time), \FFMpeg\Coordinate\TimeCode::fromSeconds($duration));

$format = new FFMpeg\Format\Video\X264();
$format->setAudioCodec("libmp3lame");
$format->on('progress', function ($video, $format, $percentage) {
    echo "转码中.. $percentage% \n";
});

$format
    ->setKiloBitrate(1000)// 视频码率
    ->setAudioChannels(2)// 音频声道
    ->setAudioKiloBitrate(256); // 音频码率
$video->save($format, $target_dir);

print "拆分成功，文件地址：{$target_dir}";

