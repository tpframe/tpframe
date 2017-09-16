<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\service;
use \tpfcore\Core;
/**
 * 设置中心
 */
class Setting extends AdminServiceBase
{
	public function clearRuntime(){
		return Core::loadModel($this->name)->clearRuntime();
	}
	public function editSetting($data){
		return Core::loadModel($this->name)->editSetting($data);
	}
	public function getSetting($data){
		return Core::loadModel($this->name)->getSetting($data);	
	}
}
