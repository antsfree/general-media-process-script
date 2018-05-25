<?php
/**
 * 音视频合并
 */
require_once 'init.php';

//$source_dir = '/Users/markxu/Downloads/hua.mp4';
$source_dir = './split1.mp4';
$video = $ffmpeg->open($source_dir);


$format = new FFMpeg\Format\Video\X264();
$format->setAudioCodec("libmp3lame");
$format->on('progress', function ($video, $format, $percentage) {
    echo "转码中.. $percentage% \n";
});



$target_dir = './concat.mp4';
$video->concat([
    './hua.mp4',
    './split2.mp4',
])->saveFromDifferentCodecs($format, $target_dir);