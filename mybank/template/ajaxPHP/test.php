<?php
include_once("../CLASS/FFMPEG.class.php");
include_once("../config.php");
$full_path='ftp://test:test@61.28.18.98/video/A001.avi';
$md5=md5_file($full_path) or die("NO_@_@@_@_MD5");
echo $md5;
$pth='/video/A001.avi';
echo (FTP_FFMPEG_PATH.$pth);
$movie=new FFMPEGCLASS(FTP_FFMPEG_PATH.$pth,false);
$movie->open();
$time=$movie->getCountTime();
echo $time;
exit();
$md5=md5_file('/home/ftp/ams/test/txt/1.txt');
echo $md5;
$md5=md5_file('ftp://test:test@www.sharp-i.net/txt/1.txt');
echo $md5;
?>