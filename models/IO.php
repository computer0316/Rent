<?php

namespace app\models;

class IO{
	/*
		读取一个文本文件
		返回一个该文本文件的行数组
	*/
	public static function getStringsFromFile($filename){
		if(file_exists($filename)){
			$str = file_get_contents($filename);//将整个文件内容读入到一个字符串中
			$strs = explode("\r\n", $str);
		}
		return $strs;
	}

}



