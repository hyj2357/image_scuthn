<?php
    function g($index){
	   $SP = "/";  //url�ָ���
       $IMAGE_SERVER_HOST = "http://localhost";   //ͼƬ������������
	   $IMAGE_APP = "image_scuthn";   //ͼƬ������Ӧ����
	   $SERVICE_SERVER_HOST = "http://localhost:8080";  //ҵ�������������
	   $SERVICE_APP = "scuthnweb2";   //ҵ�������Ӧ����
       $SERVICE_ACCESS_URL_PREFIX = "AcceptImage";  //ҵ����������ͼƬurlǰ׺
	   $FILE_ROOT = realpath(dirname(__FILE__))."\\";  //ͼƬ�ļ���Ŀ¼
       $IMAGE_ACCESS_URL_PREFIX = $IMAGE_SERVER_HOST.$SP.$IMAGE_APP.$SP."imgDetail.php?p="; //ͼƬ����urlǰ׺
	   
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