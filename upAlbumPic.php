<?php
/** ·ÏÆúSAE storage·½·¨
use sinacloud\sae\Storage as Storage;
// ·½·¨Ò»£ºÔÚSAEÔËÐÐ»·¾³ÖÐÊ±¿ÉÒÔ²»´«ÈÏÖ¤ÐÅÏ¢£¬Ä¬ÈÏ»á´ÓÓ¦ÓÃµÄ»·¾³±äÁ¿ÖÐÈ¡
$s = new Storage();
 **/
include 'thumb_image.php';

date_default_timezone_set("Asia/Hong_Kong");
if ($_FILES["file"]["error"] > 0){
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
}
else{
    header('Content-type: text/json');
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
    
	$type = substr($_FILES["file"]["type"],6);
	$dateString = date("YmdHis")."";
    $path = "images/album/".$aid."/album_".$aid."_".$num."_".$dateString.".$type";
    $path_thumb_320200 = "images/album/".$aid."/album_".$aid."_".$num."_".$dateString."_thumb_320200".".$type";

	if(!is_dir("images/album/".$aid))
        mkdir("images/album/".$aid);
    move_uploaded_file($_FILES["file"]["tmp_name"],$path);
    $isSucc = img2thumb($path, $path_thumb_320200, $width = 320, $height = 200, $cut = 0, $proportion = 0);
    if($isSucc){
	  $returndata = array(
          "file" => $path
      );
	}else{
	  unlink($path);
	  $returndata = array(
          "file" => ""
      );
	}
    echo json_encode($returndata);
}

