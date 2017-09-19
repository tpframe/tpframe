<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\service;
use \tpfcore\Core;
/**
 * 会员信息
 */
class Member extends AdminServiceBase
{
	public function uppwd($data){
		return Core::loadModel($this->name)->uppwd($data);
	}
	public function upUserInfo($data){
		return Core::loadModel($this->name)->upUserInfo($data);
	}
	public function getInfo($where){
		return Core::loadModel($this->name)->getInfo($where);
	}
	public function getUserList($data,$field="*"){
		return Core::loadModel($this->name)->getUserList($data,$field);
	}
	public function addUser($data){
		return Core::loadModel($this->name)->addUser($data);	
	}
	public function ban($data){
		return Core::loadModel($this->name)->ban($data);
	}
	public function priv($data){
		return Core::loadModel($this->name)->priv($data);
	}
	public function editUser($data){
		return Core::loadModel($this->name)->editUser($data);
	}
}
