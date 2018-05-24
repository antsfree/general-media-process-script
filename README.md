## 本地常规格式音视频互转脚本

### 🚀🚀 解决问题

> 服务器端或者本地音视频的简单自处理，无需下载转码重传

### 🌏🌏 环境配置要求

> 1. php > 5.6
> 2. ffmpeg
> 3. composer

### 📚📚 配置及使用方法

配置：

```
1. git clone git@github.com:antsfree/general-media-transcode.git

2. cd /path/to/general-media-transcode && composer install

```

转码脚本使用(交互模式)：

```
☁  local-transcode [develop] ⚡  php transcode.php
原媒体文件地址：
/Users/markxu/Downloads/dou.mp4
转码后文件地址：
/Users/markxu/Downloads/dou-1.mp3
原视频路径: /Users/markxu/Downloads/dou.mp4
视频时长: 49.7 Seconds
视频大小: 3.5637 MB
转码中.. 49% 
转码中.. 99% 
转码完成!

说明：
1. 视频转视频：php transcode.php 
输入源文件参数：/path/to/source.wmv 
输入目标文件参数：/path/to/target.mp4 

2. 视频提取音频：php transcode.php 
输入源文件参数：/path/to/source-video.mp4
输入目标文件参数：/path/to/target-audio.mp3 

3. 音频转视频，音频转音频，同理。

```

截图脚本使用(交互模式)：

```
☁  local-transcode [develop] ⚡  php screenshot.php 
输入原视频地址(回车结束)：
/Users/markxu/Downloads/dou.mp4
视频总时长：49.709000
输入截取的时间点，单位秒(回车结束)：
40
截图保存名：
dou.png
图片截取成功：/Users/markxu/Downloads/dou.png 

```

### 🌲🌲 实测支持类型

> 音频：mp3 wav 等
> 
> 视频：avi wmv mp4 flv wav 等

### 🔥🔥 说明

> 说这么多，会 ffmpeg 命令就全能搞定了，其实我就图个自己方便。：）

