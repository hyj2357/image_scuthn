<?php
    function g($index){
	   $SP = "/";  //url分隔符
       $IMAGE_SERVER_HOST = "http://localhost";   //图片服务器主机名
	   $IMAGE_APP = "image_scuthn";   //图片服务器应用名
	   $SERVICE_SERVER_HOST = "http://localhost:8080";  //业务服务器主机名
	   $SERVICE_APP = "scuthnweb2";   //业务服务器应用名
       $SERVICE_ACCESS_URL_PREFIX = "AcceptImage";  //业务主机接受图片url前缀
	   $FILE_ROOT = realpath(dirname(__FILE__))."\\";  //图片文件根目录
       $IMAGE_ACCESS_URL_PREFIX = $IMAGE_SERVER_HOST.$SP.$IMAGE_APP.$SP."imgDetail.php?p="; //图片访问url前缀
	   
	   if(strcmp($index,"SP")==0)
		   return $SP;
	   else if(strcmp($index,"IMAGE_SERVER_HOST")==0)
		   return $IMAGE_SERVER_HOST;
       else if(strcmp($index,"IMAGE_APP")==0)
		   return $IMAGE_APP;
       else if(strcmp($index,"SERVICE_SERVER_HOST")==0)
		   return $SERVICE_SERVER_HOST;
       else if(strcmp($index,"SERVICE_APP")==0)
		   return $SERVICE_APP;  
       else if(strcmp($index,"SERVICE_ACCESS_URL_PREFIX")==0)
		   return $SERVICE_ACCESS_URL_PREFIX;
	   else if(strcmp($index,"FILE_ROOT")==0)
		   return $FILE_ROOT; 
	   else if(strcmp($index,"IMAGE_ACCESS_URL_PREFIX")==0)
		   return $IMAGE_ACCESS_URL_PREFIX;
    }