<?php
	include 'params.php';

	/*���ÿ������*/
	$origin = isset($_SERVER['HTTP_ORIGIN'])?$_SERVER['HTTP_ORIGIN']:"";
	$allow_origin = array(
	   g('SERVICE_SERVER_HOST')
	);
	if(in_array($origin, $allow_origin)){
	   header("Access-Control-Allow-Origin:".$origin);
       header("Access-Control-Allow-Methods:POST");
       header("Access-Control-Allow-Headers:x-requested-with,content-type");
	}
	
	date_default_timezone_set("Asia/Hong_Kong");

	//��ȡQuery����
	$p = $_REQUEST['p'];
	$path = g('FILE_ROOT').$p;

	$extType = pathinfo($path, PATHINFO_EXTENSION);
	$img = file_get_contents($path,true);

    //ʹ��ͼƬͷ��������
    header("Content-Type: image/$extType;text/html; charset=utf-8");
    echo $img;

/**
	$p = $_REQUEST['p'];
	$prefix = "D:\\phpWWW\\image_scuthn\\";

	$path = $prefix.$p;
    $im = imagecreatefromjpeg($path);
    imagejpeg($im);

**/