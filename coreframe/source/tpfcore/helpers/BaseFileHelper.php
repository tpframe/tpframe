<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */

namespace tpfcore\helpers;

use tpfcore\base\ErrorException;
use tpfcore\base\InvalidConfigException;
use tpfcore\base\InvalidParamException;

class BaseFileHelper
{
	/**
	 * 获取远程文件
	 */
    public static function getRemoteFile($url, $save_dir = '', $is_newfilename = false, $type = 0) {  
	    if (trim($url) == '') {  
	        return ['error_code'=>1,'err_msg'=>'下载地址为空']; 
	    }  
	    if (trim($save_dir) == '') {  
	        $save_dir = './';  
	    }  
	    //创建保存目录  
	    if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {  
	        return ['error_code'=>1,'err_msg'=>'创建目录地址失败']; 
	    }
	    //重新命名文件
	    if($is_newfilename==true){
	        $ext=strrchr($url,'.'); 
	        $filename=md5($url).$ext; 
	    }else{
	        $filename=basename($url);

	    }
	    //获取远程文件所采用的方法  
	    if ($type) {  
	        $ch = curl_init();  
	        $timeout = 10;  
	        if(stripos($url,"https://")!==false){
	            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
	            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
	            // curl_setopt ($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V6);
	        }
	        curl_setopt($ch, CURLOPT_URL, $url);  
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
	        $content = curl_exec($ch);
	        if($error=curl_error($ch)){
	            //var_dump(curl_getinfo($ch)); 
	            //echo curl_errno($ch);
	            //die($error);
	            return ['error_code'=>1,'err_msg'=>$error]; 
	        }
	        curl_close($ch);  
	    } else {  
	        ob_start();  
	        readfile($url);  
	        $content = ob_get_contents();  
	        ob_end_clean();  
	    }  
	    $size = strlen($content);
	    //文件大小  
	    $fp2 = @fopen($save_dir . $filename, 'a');  
	    fwrite($fp2, $content);  
	    fclose($fp2);  
	    unset($content, $url);  
	    return array(  
	    	'error_code'=>0,
	        'file_name' => $filename,  
	        'save_path' => $save_dir . $filename,  
	        'file_size' => $size,
	    );  
	}
}
