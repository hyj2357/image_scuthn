<?php
/**
	$data = array ('type' => 'user_icon',
				   'uid'  => '7',
				   'path' => 'http://imagescuthn-image1.stor.sinaapp.com/album%2F123%2Falbum_123_1_20160215171927.png');  
   **/
	//��ȡQuery����
	$arr = explode("&",$_SERVER["QUERY_STRING"],3);	
	$uid = substr($arr[0],4);
	$sid = substr($arr[1],4);
	$path= substr($arr[2],5);

   	$data = array ('type' => 'user_icon',
				   'uid'  => $uid,
			       'sid'  => $sid,
				   'path' => $path);

	//����url-encode��������ַ�����������ת��Ϊ�ַ���  
    $data = http_build_query($data);  
    $opts = array (  
		'http'   => array (  
		'method' => 'POST',  
		'header' => "Content-type: application/x-www-form-urlencoded\r\n" .  
		            "Content-Length: ".strlen($data)."\r\n",  
		'content'=> $data)  
    );  
    //��������ľ���ļ�  
    $context = stream_context_create($opts);  
    $j = file_get_contents('http://139.129.24.81:8082/scuthnweb2/AcceptImage', false, $context); 
	echo $j.'<br/>';
	$_j = json_decode($j,true);
    echo "return content:".$_j['accept']."<br/>";
	echo "return content:".$_j['lastUrl']."<br/>";
	$_lastUrl = $_j['lastUrl'];
	echo "url:".$_lastUrl."<br/>";
	$bucket = "image1";
    $temp = str_replace("http://imagescuthn-".$bucket.".stor.sinaapp.com/","",$_lastUrl);
    echo "temp:".$temp."<br/>";
	$object = str_replace("%2F","/",$temp);
    echo "object:".$object."<br/>";
	/**
	$_accept = $_j['isLogin'];
	if(strcmp($_accept,"true")==0)
		echo "lala";
	else
		echo "bubu...";**/
?>