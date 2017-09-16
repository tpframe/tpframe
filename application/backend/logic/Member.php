<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\logic;
use \tpfcore\Core;
/**
 *  会员逻辑
 */
class Member extends AdminBase
{
	protected $table;
	public function __construct(){
		$this->table=config('database.prefix').'user';
		$this->name="User";
	}
	public function uppwd($data){
		$validate=\think\Loader::validate("Member");
		$validate_result = $validate->scene('update')->check($data);
        if (!$validate_result) {    
            return [RESULT_ERROR, $validate->getError(), null];
        }
        if(!$this->checkPassword($data)){
        	return [RESULT_ERROR, '旧密码不正确', null];
        }
        if(self::updateObject(['username'=>\think\Session::get("backend_author_sign")['username']],["password"=>md5($data['password'])])){
        	\think\Session::delete("backend_author_sign");
        	return [RESULT_SUCCESS, '修改密码成功，请重新登录', url('User/login')];
        } 
	}
	public function upUserInfo($data){
		$validate=\think\Loader::validate("Member");
		$validate_result = $validate->scene('upinfo')->check($data);
        if (!$validate_result) {    
            return [RESULT_ERROR, $validate->getError(), null];
        }
        $result=self::updateObject(['id'=>\think\Session::get("backend_author_sign")['userid']],$data);
        if($result){
        	return [RESULT_SUCCESS, '修改资料成功', null];
        }
	}
	public function getInfo($where){
		return self::getOneObject($where);
	}
	public function checkPassword($data){
		return self::getStatistics(['username'=>\think\Session::get("backend_author_sign")['username'],"password"=>md5($data['old_password'])]);
	}
	public function getUserList($where = [], $field = true, $order = '', $is_paginate = true){
		$paginate_data = $is_paginate ? ['rows' => DB_LIST_ROWS] : false;
		return self::getObject($where, $field, $order, $paginate_data);
	}
	public function addUser($data){
		$validate=\think\Loader::validate("Member");
		$validate_result = $validate->scene('add')->check($data);
        if (!$validate_result) {    
            return [RESULT_ERROR, $validate->getError(), null];
        }
        $result=Core::loadModel($this->name)->saveObject($data);
		if($result){
			return [RESULT_SUCCESS, '操作成功', url('Member/admin')];
		}else{
			return [RESULT_ERROR, '操作失败', url('Member/admin')];
		}
	}
	public function ban($data){
		self::saveObject($data);
		return [RESULT_SUCCESS, '操作成功', null];
	}
	public function priv($data){
		$result=Core::loadModel($this->name)->saveObject($data);
		if($result){
			return [RESULT_SUCCESS, '操作成功', url('Member/admin')];
		}
		return [RESULT_ERROR, '操作失败', url('Member/admin')];
	}
}