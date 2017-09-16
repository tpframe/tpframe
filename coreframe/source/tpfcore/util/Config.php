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
}