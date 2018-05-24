<?php
require_once 'init.php';

// 参数处理
$source_dir       = input("原媒体文件地址："); // 源文件
$target_dir       = input("转码后文件地址："); // 目标文件
$source_extension = get_extension($source_dir);
$target_extension = get_extension($target_dir);
if ($target_extension == $source_extension) {
    die("该文件转码后缀类型一致，无需转码。\n");
}

// 加载 php-ffmpeg 扩展
$ffprobe  = FFMpeg\FFProbe::create();
$is_video = $ffprobe->isValid($source_dir); // returns bool
if (!$is_video) die('视频格式问题');
$video_info = $ffprobe->format($source_dir)->all();
echo "原视频路径: {$video_info['filename']}\n";
$duration = format_duration($video_info['duration']);
echo "视频时长: {$duration}\n";
$size = format_size($video_info['size']);
echo "视频大小: {$size}\n";

$video = $ffmpeg->open($source_dir);

// 格式限制
$extension = [
    'avi',
    'wmv',
    'mp4',
    'flv',
    'mp3',
    'wav',
];
if (!in_array($target_extension, $extension)) die("暂不支持 {$target_extension} 格式转码\n");
$format = new FFMpeg\Format\Video\X264();
$format->setAudioCodec("libmp3lame");
$format->on('progress', function ($video, $format, $percentage) {
    echo "转码中.. $percentage% \n";
});

$format
    ->setKiloBitrate(1000) // 视频码率
    ->setAudioChannels(2) // 音频声道
    ->setAudioKiloBitrate(256); // 音频码率

// 保存
$video->save($format, $target_dir);

die("转码完成!\n");