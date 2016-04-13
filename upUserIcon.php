<?php
	include 'check.php';
	include 'thumb_image.php';
    

	header('Content-type: text/json');
	/*设置跨域访问*/
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

	//获取Query参数
    $uid = $_REQUEST['uid'];
	$sid = $_REQUEST['sid'];

	$result= "";
	//图片类型为 png, jpeg 或 jpg
	if(strcmp($_FILES["file"]["type"],"image/png")==0||strcmp($_FILES["file"]["type"],"image/jpeg")==0||strcmp($_FILES["file"]["type"],"image/jpg")==0){
		/*图片大小不超过2MB*/
		if($_FILES["file"]["size"]<2*1024*1024){			
			$type = substr($_FILES["file"]["type"],6);							//截取“image/type”后面的type
		    
			/*生成图片相对路径*/
			$dateString = date("YmdHis")."";
			
			$path = "images/user/user_icon_".$uid."_".$dateString.".$type";         
			$path_thumb_129129 = "images/user/user_icon_".$uid."_".$dateString."_thumb_129129".".$type";

			
			/**生成图片文件访问url*/
			$url_path = g('IMAGE_ACCESS_URL_PREFIX').$path;
			$url_path_thumb_129129 = g('IMAGE_ACCESS_URL_PREFIX').$path_thumb_129129;

			if(!is_dir('images/user/'))
				mkdir("images/user/");

			$_check = new Check();
			if($_check->checkUploadUserIcon($url_path_thumb_129129,$uid,$sid)){
				/*转存头像图片*/
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