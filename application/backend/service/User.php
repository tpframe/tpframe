<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\service;
use \tpfcore\Core;
/**
 * 用户中心
 */
class User extends AdminServiceBase
{
	public function logout(){
		return Core::loadModel($this->name)->logout();
	}
	public function login($data){
		return Core::loadModel($this->name)->login($data);
	}
}
