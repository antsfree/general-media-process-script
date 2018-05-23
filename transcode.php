<?php
if ($argc != 3) {
    die('执行错误！示例: php transcode.php /path/to/source.wmv /path/to/target.mp4');
}
// 1、检测 PHP 环境
if (version_compare(PHP_VERSION, '5.3.0', '<')) die('require PHP > 5.3.0 !');

// 2、引入帮助函数
require_once './function.php';

// 3、检测 ffmpeg 和 ffprobe 服务
$ret = get_command_result('ffmpeg --version');
if (!strpos($ret[0], 'version')) die('未安装 ffmpeg !');
$ret = get_command_result('ffprobe --version');
if (!strpos($ret[0], 'version')) die('未安装 ffprobe !');

// 4、提取 ffmpeg 及 ffprobe
$ret = get_command_result('which ffmpeg ffprobe');
if (count($ret) != 2) die("未找到对应可执行程序!\n");
list($ffmpeg_binaries, $ffprobe_binaries) = $ret;

// 5、参数处理
$source_dir       = $argv[1]; // 源文件
$source_extension = get_extension($source_dir);
$target_dir       = $argv[2]; // 目标文件
$target_extension = get_extension($target_dir);
if ($target_extension == $source_extension) {
    die("该文件转码后缀类型一致，无需转码。\n");
}

// 6、加载 php-ffmpeg 扩展
require 'vendor/autoload.php';
$ffprobe  = FFMpeg\FFProbe::create();
$is_video = $ffprobe->isValid($source_dir); // returns bool
if (!$is_video) die('视频格式问题');
$video_info = $ffprobe->format($source_dir)->all();
echo "原视频路径: {$video_info['filename']}\n";
$duration = format_duration($video_info['duration']);
echo "视频时长: {$duration}\n";
$size = format_size($video_info['size']);
echo "视频大小: {$size}\n";

$ffmpeg = FFMpeg\FFMpeg::create([
    'ffmpeg.binaries'  => $ffmpeg_binaries,
    'ffprobe.binaries' => $ffprobe_binaries,
    'timeout'          => 3600, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
]);
$video  = $ffmpeg->open($source_dir);

// 7、格式限制
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
    ->setKiloBitrate(1000)// 视频码率
    ->setAudioChannels(2)// 音频声道
    ->setAudioKiloBitrate(256); // 音频码率

// 8、保存
$video->save($format, $target_dir);

die("转码完成!\n");