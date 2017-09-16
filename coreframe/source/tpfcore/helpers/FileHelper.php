<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */

namespace tpfcore\helpers;

/**
 * File system helper
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Alex Makarov <sam@rmcreative.ru>
 * @since 2.0
 */
class FileHelper extends BaseFileHelper
{
	/**
	 * 获取目录下所有文件
	 */
	static final function file_list($path = '')
	{
	    
	    $file = scandir($path);
	    
	    foreach ($file as $k => $v) {
	        
	        if (is_dir($path . '/' . $v)) {

	            unset($file[$k]);
	        }
	    }
	    
	    return array_values($file);
	}
	/**
	 * 保存文件
	 */
	static final function savefile($arr = [], $fpath = '')
	{
	    
	    $data = "<?php\nreturn ".var_export($arr, true).";\n?>";
	    
	    file_put_contents($fpath, $data);
	}
	/**
	 * 获取目录列表
	 */
	static final function get_dir($dir_name)
	{
	    
	    $dir_array = [];
	    
	    if (false != ($handle = opendir($dir_name))) {
	        
	        $i = 0;
	        
	        while (false !== ($file = readdir($handle))) {
	            
	            if ($file != "." && $file != ".."&&!strpos($file,".")) {
	                
	                $dir_array[$i] = $file;
	                
	                $i++;
	            }
	        }
	        
	        closedir($handle);
	    }
	    
	    return $dir_array;
	}
}
