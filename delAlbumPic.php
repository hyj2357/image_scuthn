<?php
	include 'thumb_image.php';
	include 'check.php';

    

	header('Content-type: text/json');
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
    $uid = $_REQUEST['uid'];
	$sid = $_REQUEST['sid'];
    $aid = $_REQUEST['aid'];
    $pid = $_REQUEST['pid'];
    
	$data = "";
	$_check = new Check();
    if($_check->checkDeleAlbumPic($aid,$sid,$uid,$pid)){
	    $data = array(
			"accept"=>"true"
		);
	}else{
	    $data = array(
			"accept"=>"false"
		);		
	}
	
	echo json_encode($data);
	return;