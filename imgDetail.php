<?php
    include 'Image.class.php';
	include 'check.php';
	include 'params.php';

	date_default_timezone_set("Asia/Hong_Kong");

	//获取Query参数
	$p = $_REQUEST['p'];
	$path = $FILE_ROOT.$p;

	$extType = pathinfo($path, PATHINFO_EXTENSION);
	$img = file_get_contents($path,true);

    //使用图片头输出浏览器
    header("Content-Type: image/$extType;text/html; charset=utf-8");
    echo $img;

/**
	$p = $_REQUEST['p'];
	$prefix = "D:\\phpWWW\\image_scuthn\\";

	$path = $prefix.$p;
    $im = imagecreatefromjpeg($path);
    imagejpeg($im);

**/