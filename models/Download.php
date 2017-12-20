<?php

namespace app\models;

class Download{

		public static function getMiddle($str, $strleft, $strright){
			$patt = '/(?<=' . $strleft . ')[\w\W]*?(?=' . $strright .')/';
			$matches = array();
			preg_match_all($patt,$str,$matches);
			return $matches[0];
		}

		public static function getMiddleStr($str, $l, $r){
			$result = self::getMiddle($str,$l,$r);
			//return self::rocTrim($result[0]);
			return $result[0];
		}

		public static function doubleGetMiddle($str, $strleft1, $strright1, $strleft2, $strright2){
			$match = self::getMiddle($str, $strleft1, $strright1);
			$match1 = self::getMiddle($match[0], $strleft2, $strright2);
			//return self::rocTrim($match1[0]);
			return $result[0];
		}

		public static function rocTrim($str){
			$result = trim($str);
			$result = str_replace("\r\n",'',$result);	// 删除行尾回车换行符
			$result = str_replace('　','',$result);		// 删除行尾空格
			$result = str_replace(' ','',$result);		// 删除行尾空格
			$result = str_replace("&nbsp;",'',$result);	// 删除行尾空格
			$result = strip_tags($result);				// 删除html
			$result = trim($result);
			return $result;
		}

	public static function getCurrentPageUrls($url){
		$preg	=	'/<a .*?href="(.*?)".*?>/is';
		$str	=	self::getPage($url);
		preg_match_all($preg, $str,$match);	//在$str中搜索匹配所有符合$preg加入$match中
		return $match[1];
	}

	/*
		将 http://www.abc.com 和 /def/ghi 组合成一个有效的 url
		$host 是前面的主机部分
		$path 是后面的路径不分
	*/
	public static function assembleUrl($host, $path){
		// 如果 $path 以 http开头，则直接返回 $path
		if(substr($path, 0, 4) == "http"){
			return $path;
		}
		// 去掉 host 最后的 /
		if(substr($host, strlen($host)-1, 1) == "/"){
			$host = substr($host, 0, strlen($host)-1);
		}
		if(substr($path, 0, 1) == "/"){
			return $host . $path;
		}
		else{
			return $host . "/" . $path;
		}
	}

	// return the content of the page
	public static function getPage($url = ""){
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
                //curl_setopt($ch,CURLOPT_MAXREDIRS,5);
                //curl_setopt($ch,CURLOPT_FOLLOWLOCATION,TRUE);
		curl_setopt($ch,CURLOPT_TIMEOUT,30);
		curl_setopt($ch,CURLOPT_HEADER,FALSE);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($ch,CURLOPT_AUTOREFERER,TRUE);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11');
		curl_setopt($ch,CURLOPT_ENCODING, 'gzip');	// gzip is ok, for the pages which don't press with gzit, it seems ok too
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);	// https supported
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		$data=curl_exec($ch);
		if(curl_errno($ch)){
			curl_close($ch);
			return false;
		}
		else{
			curl_close($ch);
			return $data;
		}
	}

	public static function getImg($url = "", $filename = "") {
	    if(is_dir(basename($filename))) {
	        echo "The Dir was not exits";
	        return false;
	    }
	    //去除URL连接上面可能的引号
	    //$url = preg_replace( '/(?:^['"]+|['"/]+$)/', '', $url );
	    $hander = curl_init();
	    $fp = fopen($filename,'wb');
	    curl_setopt($hander,CURLOPT_URL,$url);
	    curl_setopt($hander,CURLOPT_FILE,$fp);
	    curl_setopt($hander,CURLOPT_TIMEOUT,30);
	    curl_setopt($hander,CURLOPT_HEADER,0);
	    curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
	    //curl_setopt($hander,CURLOPT_RETURNTRANSFER,false);//以数据流的方式返回数据,当为false是直接显示出来
	    curl_setopt($hander,CURLOPT_TIMEOUT,60);
	    /*$options = array(
	        CURLOPT_URL=> '/thum-f3ccdd27d2000e3f9255a7e3e2c4880020110622095243.jpg',
	        CURLOPT_FILE => $fp,
	        CURLOPT_HEADER => 0,
	        CURLOPT_FOLLOWLOCATION => 1,
	        CURLOPT_TIMEOUT => 60
	    );
	    curl_setopt_array($hander, $options);
	    */
	    curl_exec($hander);
	    curl_close($hander);
	    fclose($fp);
	    return  true;
	}
}



