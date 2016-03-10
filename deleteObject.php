<?php
	use sinacloud\sae\Storage as Storage;
	
	$s = new Storage();	
	$bucket = "image1";
	//获取Query参数
	$arr = explode("&",$_SERVER["QUERY_STRING"],3);	
	/**
	$object = substr($arr[0],5);
	
	echo $s->getUrl("image1",$object);
	$s->deleteObject("image1", $object);
	**/
	$_lastUrl = substr($arr[0],5);
	echo "url:".$_lastUrl."<br/>";
    $temp = str_replace("http://imagescuthn-".$bucket.".stor.sinaapp.com/","",$_lastUrl);
    echo "temp:".$temp."<br/>";
	$object = str_replace("%2F","/",$temp);
    echo "object:".$object."<br/>";	
	$s->deleteObject($bucket, $object);
?>