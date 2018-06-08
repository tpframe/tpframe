<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace tpfcore\util;
class Config{
	
	public static function updateConfig($file,$update_config){

		$config=require($file);

		$config=array_merge($config,$update_config);

		file_put_contents($file, "<?php \nreturn ".var_export($config,true).";");

	}
	/*
		返回某个数组键的值，支持aa.bb.cc
	*/
	public static function getConfigByKey($file,$key){

		$cache=$config=require($file);

		if(strpos($key,".")!==false){

			$arr=explode(".", $key);

			foreach ($arr as $key => $value) {

				$cache=$cache[$value];

			}

			return $cache;
			
		}
		return $config[$key];
	}
}