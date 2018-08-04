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
		$update_config=[
			'DEFAULT_THEME'=>$data['options']['DEFAULT_THEME'],
			'HTML_CACHE_ON'=>$data['options']['HTML_CACHE_ON'],
			'ADMIN_LOG_SWITCH'=>$data['options']['ADMIN_LOG_SWITCH'],
			'WEB_SITE_CLOSE'=>$data['options']['WEB_SITE_CLOSE'],
			'ADMIN_LOGIN_LLIMIT_IP'=>$data['options']['ADMIN_LOGIN_LLIMIT_IP'],
			'ADMIN_LOGIN_VERIFY_SWITCH'=>$data['options']['ADMIN_LOGIN_VERIFY_SWITCH']
		];

		unset($data['options']['DEFAULT_THEME']);
		unset($data['options']['HTML_CACHE_ON']);
		unset($data['options']['ADMIN_LOG_SWITCH']);
		unset($data['options']['WEB_SITE_CLOSE']);
		unset($data['options']['ADMIN_LOGIN_LLIMIT_IP']);
		unset($data['options']['ADMIN_LOGIN_VERIFY_SWITCH']);

		Config::updateConfig(APP_PATH."extra/config.php",$update_config);
	
		$result=Core::loadModel($this->name)->saveObject($data);
		if($result){
			return [RESULT_SUCCESS, '更新成功', url('Setting/site')];
		}else{
			return [RESULT_SUCCESS, '更新成功', url('Setting/site')];
		}
	}
	public function editMail($data){
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