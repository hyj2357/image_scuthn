<?php
	/**
	 *@author YJ.Huang
	 *
	 **/
	function checkOnline($uid,$sid){
		/**
		$data = array ('type' => 'user_icon',
					   'uid'  => '7',
					   'path' => 'http://imagescuthn-image1.stor.sinaapp.com/album%2F123%2Falbum_123_1_20160215171927.png');  
		**/
		$data = array ('uid'  => $uid,
					   'sid'  => $sid);
		//生成url-encode后的请求字符串，将数组转换为字符串  
		$data = http_build_query($data);  
		$opts = array (  
			'http'   => array (  
			'method' => 'POST',  
			'header' => "Content-type: application/x-www-form-urlencoded\r\n" .  
						"Content-Length: ".strlen($data)."\r\n",  
			'content'=> $data)  
		);  
		//生成请求的句柄文件  
		$context = stream_context_create($opts);  
		$j = file_get_contents('http://139.129.24.81:8082/scuthnweb2/Online', false, $context); 
		$_j = json_decode($j,true);
		$_accept = $_j['isLogin'];
		if(strcmp($_accept,"true")==0)
			return true;
		else
			return false;
	}

	/**
	 *@author YJ.Huang
	 **/
	function checkUploadUserIcon($bucket,$url,$uid,$sid){

		$data = array('type' => 'user_icon',
					  'uid'  => $uid,
					  'sid'  => $sid,
					  'path' => $url);
		//生成url-encode后的请求字符串，将数组转换为字符串  
		$data = http_build_query($data);  
		$opts = array (  
			'http'   => array (  
			'method' => 'POST',  
			'header' => "Content-type: application/x-www-form-urlencoded\r\n" .  
						"Content-Length: ".strlen($data)."\r\n",  
			'content'=> $data)  
		);  
		//生成请求的句柄文件  
		$context = stream_context_create($opts);  
		$j = file_get_contents('http://139.129.24.81:8082/scuthnweb2/AcceptImage', false, $context); 
		$_j = json_decode($j,true);
		$_accept = $_j['accept'];
		if(strcmp($_accept,"true")==0){
			$_lastUrl = $_j['lastUrl'];
			if(!($_lastUrl=='image/default/ui1.png') && !($_lastUrl=='image/default/ui2.png') && !($_lastUrl=='image/default/ui3.png')){ //如果不为默认头像
				$temp = str_replace("http://139.129.24.81:8083/image_scuthn/","",$_lastUrl);
				unlink($temp);
			}	
			return true;			
		}
		else
			return false;
	}

?>