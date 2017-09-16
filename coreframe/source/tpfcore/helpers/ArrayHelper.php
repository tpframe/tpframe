<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */

namespace tpfcore\helpers;

/**
 * ArrayHelper provides additional array functionality that you can use in your
 * application.
 */
class ArrayHelper extends BaseArrayHelper
{
	/**
	 * 分析数组及枚举类型配置值 格式 a:名称1,b:名称2
	 * @return array
	 */
	private function parse_config_attr($string)
	{
	    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
	    if (strpos($string, ':')) {
	        $value = [];
	        foreach ($array as $val) {
	            
	            list($k, $v) = explode(':', $val);
	            
	            $value[$k] = $v;
	        }
	    } else {
	        $value = $array;
	    }
	    return $value;
	}
	/**
	 * 解析数组配置
	 */
	static final function parse_config_array($name = '')
	{  
	    return parse_config_attr(config($name));
	}
	/**
	 * 将二维数组数组按某个键提取出来组成新的索引数组
	 */
	static final function array_extract($array = [], $key = 'id')
	{
	    
	    $count = count($array);
	    
	    $new_arr = [];
	     
	    for($i = 0; $i < $count; $i++) {
	        
	        if (!empty($array) && !empty($array[$i][$key])) {
	            
	            $new_arr[] = $array[$i][$key];
	        }
	    }
	    
	    return $new_arr;
	}

	/**
	 * 根据某个字段获取关联数组
	 */
	static final function array_extract_map($array = [], $key = 'id'){
	    
	    
	    $count = count($array);
	    
	    $new_arr = [];
	     
	    for($i = 0; $i < $count; $i++) {
	        
	        $new_arr[$array[$i][$key]] = $array[$i];
	    }
	    
	    return $new_arr;
	}
}
