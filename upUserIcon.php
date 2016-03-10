<?php
	use sinacloud\sae\Storage as Storage;
    include 'Image.class.php';
	include 'check.php';
	
	$bucket = "image1";                      //定义bucket名称

	//获取Query参数
	$arr = explode("&",$_SERVER["QUERY_STRING"],3);	
	$uid = substr($arr[0],4);
	$sid = substr($arr[1],4);
	//验证接受的用户会话是否已经登录
	if(!checkOnline($uid,$sid)){
		header('Content-type: text/json');
		$result = array(
			"isLogin"=>"false",
			"accept"=>"false",
			"url"=>""
		);
		echo json_encode($result);
		return;
	}
	else{
		// 方法一：在SAE运行环境中时可以不传认证信息，默认会从应用的环境变量中取
		$s = new Storage();		
		/**
			if ($_FILES["file"]["error"] > 0){
			  echo "Error: " . $_FILES["file"]["error"] . "<br />";
			}
			else{
			  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			  echo "Type: " . $_FILES["file"]["type"] . "<br />";
			  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			  echo "Stored in: " . $_FILES["file"]["tmp_name"]."<br/>";
			}
		 **/

		//图片类型为 png, jpeg 或 jpg
		if(strcmp($_FILES["file"]["type"],"image/png")==0||strcmp($_FILES["file"]["type"],"image/jpeg")==0||strcmp($_FILES["file"]["type"],"image/jpg")==0){
			$type = substr($_FILES["file"]["type"],6);							//截取“image/type”后面的type
			$file_name = "user_icon_".$uid."_".date('YmdHis').".$type";
			$path =  "user/".$file_name;										//path ex: image/user/user_icon_uid_20150622112343.png
			$url  =  "http://imagescuthn-".$bucket.".stor.sinaapp.com/user%2F".$file_name;
			if(checkUploadUserIcon($bucket,$url,$uid,$sid)){
				$s->putObjectFile($_FILES['file']['tmp_name'], "image1", $path);
				header('Content-type: text/json');
				$result = array(
					"isLogin"=>"true",
					"accept"=>"true",
					"url"=>$url
				);
				echo json_encode($result);
				return;
			}
			else{
				header('Content-type: text/json');
				$result = array(
					"isLogin"=>"true",
					"accept"=>"false",
					"url"=>""
				);
				echo json_encode($result);
				return;
			}
		}else{
			header('Content-type: text/json');
			$result = array(
				"isLogin"=>"true",
				"accept"=>"false",
				"url"=>""
			);
			echo json_encode($result);
			return;
		}
	}
?>