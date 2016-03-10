<?php
	use sinacloud\sae\Storage as Storage;


	// 方法一：在SAE运行环境中时可以不传认证信息，默认会从应用的环境变量中取
	$s = new Storage();
	
	if ($_FILES["file"][0]["error"] > 0)
	  {
	  echo "Error: " . $_FILES["file"]["error"] . "<br />";
	  }
	else
	  {  
		  $aid = substr($_SERVER["QUERY_STRING"],4);
		  $file_names = $_FILES["file"]["name"];
		  foreach($file_names as $file_name){
			  echo $file_name.'<br/>';
		  }
		  for($i=0;$i<count($_FILES["file"]["name"]);$i++){
			echo "Upload: " . $_FILES["file"]["name"][$i] . "<br />";
			echo "Type: " . $_FILES["file"]["type"][$i] . "<br />";
			echo "Size: " . ($_FILES["file"]["size"][$i] / 1024) . " Kb<br />";
			echo "Stored in: " . $_FILES["file"]["tmp_name"][$i]."<br/>";
			$type = substr($_FILES["file"]["type"][$i],6);	//截取“image/png”后面的png
			$s->putObjectFile($_FILES['file']['tmp_name'][$i], "image1", "album/".$aid."/album_".$aid."_".$i."_".date('YmdHis').".$type");

			header('Content-type: text/json');
			$returndata = array(
				"file" => $_FILES["file"]["name"][$i]
			);
			echo json_encode($returndata);
		  }
	  }
	/**
    $type = substr($_FILES["file"]["type"],6);	//截取“image/png”后面的png
	echo $type."<br/>";
	$uid = substr($_SERVER["QUERY_STRING"],4);
	echo "uid:".$uid."<br/>";
	$s->putObjectFile($_FILES['file']['tmp_name'], "image1", "user_icon_".$uid."_".date('YmdHis').".$type");
	**/
?>