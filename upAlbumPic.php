<?php
include 'thumb_image.php';
include 'check.php';
include 'params.php';

date_default_timezone_set("Asia/Hong_Kong");
if ($_FILES["file"]["error"] > 0){
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
}
else{
    header('Content-type: text/json');
    $arr = explode("&",$_SERVER["QUERY_STRING"],3);
    $aid = $_REQUEST['aid'];
    $num = $_REQUEST['num'];
    $file_names = $_FILES["file"]["name"];
/*	
	if(!checkOnline($uid,$sid)){
		$result = array(
				"isLogin"=>"false",
				"accept"=>"false",
				"typeerr"=>"false",
				"outmem"=>"true",
				"url"=>""
		);
		echo json_encode($result);
		return;
	}
  */  
	$type = substr($_FILES["file"]["type"],6);
	if(strcmp($_FILES["file"]["type"],"image/png")==0||strcmp($_FILES["file"]["type"],"image/jpeg")==0||strcmp($_FILES["file"]["type"],"image/jpg")==0){
		
		/*图片大小不超过200KB*/
		if($_FILES["file"]["size"]<200*1024){
		
			/*如果图片类型为jpg,则转化为jpeg*/
			$type = strcmp($type,"jpg")==0?"jpeg":$type;
			
			/*生成图片相对路径*/
			$dateString = date("YmdHis")."";
			$path = "images/album/".$aid."/album_".$aid."_".$num."_".$dateString.".$type";
			$path_thumb_320200 = "images/album/".$aid."/album_".$aid."_".$num."_".$dateString."_thumb_320200".".$type";

            /*按图片绝对路径 $FILE_ROOT.$path 进行原图存储*/
			if(!is_dir($FILE_ROOT."images/album/".$aid))
				mkdir($FILE_ROOT."images/album/".$aid);
			move_uploaded_file($_FILES["file"]["tmp_name"],$FILE_ROOT.$path);
			
			/*生成缩略图到原图路径下*/
			$isSucc = img2thumb($FILE_ROOT.$path, $FILE_ROOT.$path_thumb_320200, $width = 320, $height = 200, $cut = 1, $proportion = 0);
			
			/*成功则返回缩略图320*200的访问url*/
			if($isSucc){
			  $returndata = array(
				"isLogin"=>"true",
				"accept"=>"true",
				"typeerr"=>"false",
				"outmem"=>"false",
				"url"=>$IMAGE_ACCESS_URL_PREFIX.$path_thumb_320200
			  );
			  echo json_encode($returndata);
			  return;
			}else{
			  /*缩略图生成失败则删除原文件*/
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
}

