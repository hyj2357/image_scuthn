<?php
    
	$IMAGE_SERVER_HOST = "http://localhost/";   //图片服务器主机名
	
	$IMAGE_APP = "image_scuthn/";   //图片服务器应用名
	
	$SERVICE_SERVER_HOST = "http://139.129.24.81:8082/";  //业务服务器主机名
	
	$SERVICE_APP = "scuthnweb2/";   //业务服务器应用名

	$SERVICE_ACCESS_URL_PREFIX = "AcceptImage";
	
	$FILE_ROOT = realpath(dirname(__FILE__))."\\";  //图片文件根目录

	$IMAGE_ACCESS_URL_PREFIX = $IMAGE_SERVER_HOST.$IMAGE_APP."imgDetail.php?p="; //图片访问url前缀
	