## 本地常规格式音视频互转脚本

### 🚀🚀 解决问题

> 服务器端或者本地音视频的简单自处理，无需下载转码重传

### 🌏🌏 环境配置要求

> 1. php version > 5.6
> 2. ffmpeg
> 3. composer

### 📚📚 使用方法

```
1. git clone git@github.com:antsfree/general-media-transcode.git

2. cd /path/to/general-media-transcode && composer install

3. 视频转视频：php transcode.php /path/to/source.wmv /path/to/target.mp4 

4. 视频提取音频：php transcode.php /path/to/source-video.mp4 /path/to/target-audio.mp3 

5. 音频转视频，同理。
```

### 🌲🌲 实测支持类型

> 音频：mp3 wav 等
> 
> 视频：avi wmv mp4 flv wav 等

### 🔥🔥 说明

> 说这么多，会 ffmpeg 命令就全能搞定了，其实我就图个自己方便。：）

