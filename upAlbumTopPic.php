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
    
	/*�ļ��ϴ�ʧ��*/
	if ($_FILES["file"]["error"] > 0){
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
	}

	//��ȡQuery����
    $uid = $_REQUEST['uid'];
	$sid = $_REQUEST['sid'];
    $aid = $_REQUEST['aid'];
	$file_names = $_FILES["file"]["name"];

/**
	//��֤���ܵ��û��Ự�Ƿ��Ѿ���¼
	if(!checkOnline($uid,$sid)){
		$result = array(
			"isLogin"=>"false",
			"accept"=>"false",
			"url"=>""
		);
		echo json_encode($result);
		return;
	}
	**/
	//else{
	$type = substr($_FILES["file"]["type"],6);
	if(strcmp($_FILES["file"]["type"],"image/png")==0||strcmp($_FILES["file"]["type"],"image/jpeg")==0||strcmp($_FILES["file"]["type"],"image/jpg")==0){
		
		/*ͼƬ��С������3MB*/
		if($_FILES["file"]["size"]<3*1024*1024){
		
			/*���ͼƬ����Ϊjpg,��ת��Ϊjpeg*/
			$type = strcmp($type,"jpg")==0?"jpeg":$type;
			
			/*����ͼƬ���·��*/
			$dateString = date("YmdHis")."";
			$path = "images/album/".$aid."/album_".$aid."_".$dateString.".$type";
			$path_thumb_320200 = "images/album/".$aid."/album_".$aid."_".$dateString."_thumb_320200".".$type";
            $path_thumb_1200450 = "images/album/".$aid."/album_".$aid."_".$dateString."_thumb_1200450".".$type";

			
			/**����ͼƬ�ļ�����url*/
			$url_path = g('IMAGE_ACCESS_URL_PREFIX').$path;
			$url_path_thumb_320200 = g('IMAGE_ACCESS_URL_PREFIX').$path_thumb_320200;
			$url_path_thumb_1200450 = g('IMAGE_ACCESS_URL_PREFIX').$path_thumb_1200450;

			/*��ͼƬ����·�� $FILE_ROOT.$path ����ԭͼ�洢*/
			if(!is_dir(g('FILE_ROOT')."images/album/".$aid))
				mkdir(g('FILE_ROOT')."images/album/".$aid);

			/*���ҵ���������Ӧʧ��,�������ǰ����*/
			if(!checkUploadAlbumTopPic($url_path,$uid,$sid,$aid))
				return;

			/*����ԭͼ������ͼ��ԭͼ·����*/
			move_uploaded_file($_FILES["file"]["tmp_name"],g('FILE_ROOT').$path);
			$isSucc = img2thumb(g('FILE_ROOT').$path, g('FILE_ROOT').$path_thumb_320200, $width = 320, $height = 200, $cut = 1, $proportion = 0);
            $isSucc = img2thumb(g('FILE_ROOT').$path, g('FILE_ROOT').$path_thumb_1200450, $width = 1200, $height = 450, $cut = 1, $proportion = 0);

			
			/*�ɹ��򷵻�����ͼ320*200�ķ���url*/
			if($isSucc){
			  $returndata = array(
				"isLogin"=>"true",
				"accept"=>"true",
				"typeerr"=>"false",
				"outmem"=>"false",
				"url"=>g('IMAGE_ACCESS_URL_PREFIX').$path_thumb_320200
			  );
			  echo json_encode($returndata);
			  return;
			}else{
			  /*����ͼ����ʧ����ɾ��ԭ�ļ�*/
			  unlink($FILE_ROOT.$path);
			  
			  $returndata = array(
				"isLogin"=>"true",
				"accept"=>"false",
				"typeerr"=>"false",
				"outmem"=>"false",
				"url"=>""
			  );
			  echo json_encode($returndata);
			  return;
			}
		}else{
			$returndata = array(
				"isLogin"=>"true",
				"accept"=>"false",
				"typeerr"=>"false",
				"outmem"=>"true",
				"url"=>""
			);
			echo json_encode($returndata);
			return;
		}
	}else{
		$returndata = array(
			"isLogin"=>"true",
			"accept"=>"false",
			"typeerr"=>"true",
			"outmem"=>"false",
			"url"=>""
		);
		echo json_encode($returndata);
		return;
	}
	//}