<?php
/** 废弃SAE storage方法 
	use sinacloud\sae\Storage as Storage;
	// 方法一：在SAE运行环境中时可以不传认证信息，默认会从应用的环境变量中取
	$s = new Storage();
 **/

	if ($_FILES["file"]["error"] > 0){
	  echo "Error: " . $_FILES["file"]["error"] . "<br />";
	}
	else{
		  $arr = explode("&",$_SERVER["QUERY_STRING"],3);	
	      $aid = substr($arr[0],4);
	      $num = substr($arr[1],4);
		  
		  $file_names = $_FILES["file"]["name"];

		  //for($i=0;$i<count($_FILES["file"]["name"]);$i++){
		  /**
			echo "Upload: " . $_FILES["file"]["name"][$i] . "<br />";
			echo "Type: " . $_FILES["file"]["type"][$i] . "<br />";
			echo "Size: " . ($_FILES["file"]["size"][$i] / 1024) . " Kb<br />";
			echo "Stored in: " . $_FILES["file"]["tmp_name"][$i]."<br/>";
		   **/
			$type = substr($_FILES["file"]["type"],6);	//截取“image/png”后面的png
			$path = "album/".$aid."/album_".$aid."_".$num."_".date('YmdHisu').".$type";

			/** 保存文件 **/
			//$s->putObjectFile($_FILES['file']['tmp_name'], "image1", $path);
			move_uploaded_file($_FILES["file"]["tmp_name"],$path);

			header('Content-type: text/json');
			$returndata = array(
				"file" => $path
			);
			echo json_encode($returndata);
		  //}
	}
?>