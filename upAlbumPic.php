<?php
/** ����SAE storage���� 
	use sinacloud\sae\Storage as Storage;
	// ����һ����SAE���л�����ʱ���Բ�����֤��Ϣ��Ĭ�ϻ��Ӧ�õĻ���������ȡ
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
			$type = substr($_FILES["file"]["type"],6);	//��ȡ��image/png�������png
			$path = "album/".$aid."/album_".$aid."_".$num."_".date('YmdHisu').".$type";

			/** �����ļ� **/
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