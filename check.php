<?php
    include 'util.php';
	include 'params.php';


class Check{

	/**
	 *@author YJ.Huang
	 *
	 **/
	public function checkOnline($uid,$sid){
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
	public function checkUploadUserIcon($url,$uid,$sid){

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
		$j = file_get_contents(g('SERVICE_SERVER_HOST').g('SP').g('SERVICE_APP').g('SP').g('SERVICE_ACCESS_URL_PREFIX'), false, $context); 
		$_j = json_decode($j,true);
		$_accept = $_j['accept'];
		if(strcmp($_accept,"true")==0){
			$_lastUrl = $_j['lastUrl'];
			if(!($_lastUrl=='image/default/ui1.png') && !($_lastUrl=='image/default/ui2.png') && !($_lastUrl=='image/default/ui3.png')){ //如果不为默认头像
				$temp = str_replace(g('IMAGE_ACCESS_URL_PREFIX'),"",$_lastUrl);
				unlink($temp);
			}	
			return true;			
		}
		else
			return false;
	}

	/**
	 * 验证上传相册图片
	 * @author YJ.Huang
	 **/
	public function checkUploadAlbumPic($url,$uid,$sid,$aid){

		$data = array('type' => 'album_pic',
					  'uid'  => $uid,
					  'sid'  => $sid,
			          'id'   => $aid,
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
		$j = file_get_contents(g('SERVICE_SERVER_HOST').g('SP').g('SERVICE_APP').g('SP').g('SERVICE_ACCESS_URL_PREFIX'), false, $context); 
		$_j = json_decode($j,true);
		$_accept = $_j['accept'];
		if(strcmp($_accept,"true")==0){	
			return true;			
		}
		else
			return false;
	}

    /**
	 *
	 * 验证上传相册首页图片
	 *
	 **/
	public function checkUploadAlbumTopPic($url,$uid,$sid,$aid){
		$data = array('type' => 'album_pic_top',
					  'uid'  => $uid,
					  'sid'  => $sid,
			          'id'   => $aid,
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
		$j = file_get_contents(g('SERVICE_SERVER_HOST').g('SP').g('SERVICE_APP').g('SP').g('SERVICE_ACCESS_URL_PREFIX'), false, $context); 
		$_j = json_decode($j,true);
		$_accept = $_j['accept'];
		if(strcmp($_accept,"true")==0){	
			$_lastUrl = $_j['lastUrl'];
			if(!($_lastUrl=='image/default/tree.png')){ //如果不为默认首页图
				
				$temp = str_replace(g('IMAGE_ACCESS_URL_PREFIX'),"",$_lastUrl);
			
				/*删除原图以及缩略图*/
				unlink($temp);				
				unlink(sourceFileNameToThumbFileNameX($temp,"320200"));
                unlink(sourceFileNameToThumbFileNameX($temp,"1200450"));
			}
			return true;
		}
		else
			return false;        
 	}


    /**
	 *
	 * 验证删除相册图片
	 *
	 **/	
    public function checkDeleAlbumPic($aid,$sid,$uid,$pid){
		$data = array('type' => 'd_album_pic',
					  'uid'  => $uid,
					  'sid'  => $sid,
			          'id'   => $aid,
					  'pid' => $pid);
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
		$j = file_get_contents(g('SERVICE_SERVER_HOST').g('SP').g('SERVICE_APP').g('SP').g('SERVICE_ACCESS_URL_PREFIX'), false, $context); 
		$_j = json_decode($j,true);
		$_accept = $_j['accept'];

		/*业务服务器端如果接受返回true，反之返回false*/
		if(strcmp($_accept,"true")==0){
			$_lastUrl = $_j['lastUrl'];
			$temp = str_replace(g('IMAGE_ACCESS_URL_PREFIX'),"",$_lastUrl);
			
			/*删除原图以及缩略图*/
			unlink($temp);				
			unlink(sourceFileNameToThumbFileNameX($temp,"320200"));
			return true;
		}
		else
			return false;

	}

}