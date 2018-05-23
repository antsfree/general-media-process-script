<?php
/**
 * Created by PhpStorm.
 * User: markxu
 * Date: 2018/5/23
 * Time: 下午5:55
 */
/**
 * 获取文件后缀
 *
 * @param $file_dir
 *
 * @return string
 */
function get_extension($file_dir)
{
    $file_name = basename($file_dir);
    $extension = ltrim(strrchr($file_name, '.'), '.');

    return $extension;
}

/**
 * 获取命令输出返回
 *
 * @param $command
 *
 * @return mixed
 */
function get_command_result($command)
{
    $command = $command . ' 2>&1';
    exec($command, $result);

    return $result;
}

/**
 * 文件大小格式化
 *
 * @param     $size
 * @param int $i
 *
 * @return string
 */
function format_size($size, $i = 1)
{
    $format = [
        1 => 'B',
        2 => 'KB',
        3 => 'MB',
        4 => 'GB',
        5 => 'TB',
        // ...哪会那么大 ：）
    ];
    while ($size > 1024) {
        $i++;
        $size = $size / 1024;
        format_size($size, $i);
    }
    $size = number_format($size, 4);

    return $size . ' ' . $format[$i];
}

/**
 * 时间格式化
 *
 * @param     $duration
 * @param int $i
 *
 * @return string
 */
function format_duration($duration, $i = 1)
{
    $format = [
        1 => 'Seconds',
        2 => 'Minutes',
        3 => 'Hours',
    ];
    while ($duration >= 60) {
        $i++;
        $duration = $duration / 60;
        format_duration($duration, $i);
    }
    $duration = number_format($duration, 1);

    return $duration . ' ' . $format[$i];
}