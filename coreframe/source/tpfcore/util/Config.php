<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace tpfcore\util;
class Config{
	
	/* 
		简单数组合并
	*/
	public static function updateConfig($file,$update_config){

		$config=require($file);

		$config=array_merge($config,$update_config);

		file_put_contents($file, "<?php \nreturn ".var_export($config,true).";");

	}

	/*
		多维数组合并
	*/
	public static function mult_array_merge($file,$update_config){

		$config = require($file);

		Config::array_merge($config,$update_config);

		file_put_contents($file, "<?php \nreturn ".var_export($config,true).";");
	}

	
	private static function array_merge(&$old_arr,$new_arr)
	{
	    foreach ($new_arr as $key => $value) {
	        if(is_array($value)){
	            Config::array_merge($old_arr[$key],$value);
	        }else{
	            $old_arr[$key]=$value;
	        }
	    }
	    return $old_arr;
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