<?php
	include 'check.php';
	include 'thumb_image.php';
    

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

	$result= "";
	//ͼƬ����Ϊ png, jpeg �� jpg
	if(strcmp($_FILES["file"]["type"],"image/png")==0||strcmp($_FILES["file"]["type"],"image/jpeg")==0||strcmp($_FILES["file"]["type"],"image/jpg")==0){
		/*ͼƬ��С������2MB*/
		if($_FILES["file"]["size"]<2*1024*1024){			
			$type = substr($_FILES["file"]["type"],6);							//��ȡ��image/type�������type
		    
			/*����ͼƬ���·��*/
			$dateString = date("YmdHis")."";
			
			$path = "images/user/user_icon_".$uid."_".$dateString.".$type";         
			$path_thumb_129129 = "images/user/user_icon_".$uid."_".$dateString."_thumb_129129".".$type";

			
			/**����ͼƬ�ļ�����url*/
			$url_path = g('IMAGE_ACCESS_URL_PREFIX').$path;
			$url_path_thumb_129129 = g('IMAGE_ACCESS_URL_PREFIX').$path_thumb_129129;

			if(!is_dir('images/user/'))
				mkdir("images/user/");

			$_check = new Check();
			if($_check->checkUploadUserIcon($url_path_thumb_129129,$uid,$sid)){
				/*ת��ͷ��ͼƬ*/
				move_uploaded_file($_FILES["file"]["tmp_name"],g('FILE_ROOT').$path);	
				$isSucc = img2thumb(g('FILE_ROOT').$path, g('FILE_ROOT').$path_thumb_129129, $width = 129, $height = 129, $cut = 1, $proportion = 0);
				
				$result = "";
				if($isSucc){
					$result = array(
						"isLogin"=>"true",
						"accept"=>"true",
						"url"=>$url_path_thumb_129129
					);
				}else{
					$result = array(
						"isLogin"=>"true",
						"accept"=>"false",
						"url"=>""
					);
				}
				unlink(g('FILE_ROOT').$path);
				echo json_encode($result);
				return;
			}
			else{
				$result = array(
					"isLogin"=>"true",
					"accept"=>"false",
					"url"=>""
				);
				echo json_encode($result);
				return;
			}
		}else{
			$result = array(
				"isLogin"=>"true",
				"accept"=>"false",
				"url"=>""
			);
			echo json_encode($result);
			return;
		}
	}else{
		$result = array(
			"isLogin"=>"true",
			"accept"=>"false",
			"outmem"=>"true",
			"url"=>""
		);
		echo json_encode($result);
		return;
	}

?>