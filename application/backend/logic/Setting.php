<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\logic;
use \tpfcore\Core;
use \tpfcore\util\Config;
/**
 *  设置逻辑
 */
class Setting extends AdminBase
{
	public function clearRuntime(){
		\think\Cache::clear();		//清空cache
    	array_map('unlink',glob(TEMP_PATH.DS.'*.php')); 	//清空temp
    	$path = glob(LOG_PATH.'/*'); 
		foreach ($path as $item) { 
			array_map('unlink',glob($item.DS.'*.*')); 
			rmdir($item);
		}
        return [RESULT_SUCCESS, '缓存已更新成功', url('Index/main')];
	}
	public function  editSetting($data){
		$update_config=['DEFAULT_THEME'=>$data['options']['site_tpl'],'HTML_CACHE_ON'=>isset($data['options']['html_cache_on'])?true:false];

		Config::updateConfig("./data/conf/config.php",$update_config);
	
		$data=\tpfcore\helpers\Json::arrayValueToJson($data);
		$result=Core::loadModel($this->name)->saveObject($data);
		if($result){
			return [RESULT_SUCCESS, '更新成功', url('Setting/site')];
		}else{
			return [RESULT_ERROR, '更新失败', url('Setting/site')];
		}
	}
	public function getSetting($data){
		return self::getOneObject($data);
	}
}