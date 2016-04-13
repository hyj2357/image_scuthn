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
		$j = file_get_contents(g('SERVICE_SERVER_HOST').g('SP').g('SERVICE_APP').g('SP').g('SERVICE_ACCESS_URL_PREFIX'), false, $context); 
		$_j = json_decode($j,true);
		$_accept = $_j['accept'];
		if(strcmp($_accept,"true")==0){
			$_lastUrl = $_j['lastUrl'];
			if(!($_lastUrl=='image/default/ui1.png') && !($_lastUrl=='image/default/ui2.png') && !($_lastUrl=='image/default/ui3.png')){ //�����ΪĬ��ͷ��
				$temp = str_replace(g('IMAGE_ACCESS_URL_PREFIX'),"",$_lastUrl);
				unlink($temp);
			}	
			return true;			
		}
		else
			return false;
	}

	/**
	 * ��֤�ϴ����ͼƬ
	 * @author YJ.Huang
	 **/
	public function checkUploadAlbumPic($url,$uid,$sid,$aid){

		$data = array('type' => 'album_pic',
					  'uid'  => $uid,
					  'sid'  => $sid,
			          'id'   => $aid,
					  'path' => $url);
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
	 * ��֤�ϴ������ҳͼƬ
	 *
	 **/
	public function checkUploadAlbumTopPic($url,$uid,$sid,$aid){
		$data = array('type' => 'album_pic_top',
					  'uid'  => $uid,
					  'sid'  => $sid,
			          'id'   => $aid,
					  'path' => $url);

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
		$j = file_get_contents(g('SERVICE_SERVER_HOST').g('SP').g('SERVICE_APP').g('SP').g('SERVICE_ACCESS_URL_PREFIX'), false, $context); 
		$_j = json_decode($j,true);
		$_accept = $_j['accept'];
		if(strcmp($_accept,"true")==0){	
			$_lastUrl = $_j['lastUrl'];
			if(!($_lastUrl=='image/default/tree.png')){ //�����ΪĬ����ҳͼ
				
				$temp = str_replace(g('IMAGE_ACCESS_URL_PREFIX'),"",$_lastUrl);
			
				/*ɾ��ԭͼ�Լ�����ͼ*/
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
	 * ��֤ɾ�����ͼƬ
	 *
	 **/	
    public function checkDeleAlbumPic($aid,$sid,$uid,$pid){
		$data = array('type' => 'd_album_pic',
					  'uid'  => $uid,
					  'sid'  => $sid,
			          'id'   => $aid,
					  'pid' => $pid);
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
		$j = file_get_contents(g('SERVICE_SERVER_HOST').g('SP').g('SERVICE_APP').g('SP').g('SERVICE_ACCESS_URL_PREFIX'), false, $context); 
		$_j = json_decode($j,true);
		$_accept = $_j['accept'];

		/*ҵ���������������ܷ���true����֮����false*/
		if(strcmp($_accept,"true")==0){
			$_lastUrl = $_j['lastUrl'];
			$temp = str_replace(g('IMAGE_ACCESS_URL_PREFIX'),"",$_lastUrl);
			
			/*ɾ��ԭͼ�Լ�����ͼ*/
			unlink($temp);				
			unlink(sourceFileNameToThumbFileNameX($temp,"320200"));
			return true;
		}
		else
			return false;

	}

}