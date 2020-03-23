<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\logic;

/**
 *  用户逻辑
 */
class User extends AdminBase
{
	public function logout(){
		\think\Session::delete("backend_author_sign");
		return [0, '注销成功', url('User/login')];
	}
	public function login($data){
		$admin_login_limit_ip=config("config.ADMIN_LOGIN_LLIMIT_IP");
		//如果设置了IP限制登录
		if(!empty($admin_login_limit_ip)){
			$request_ip=request()->ip();
			if(stripos($request_ip,"127.0.0.")===false && !in_array($request_ip, explode(",", $admin_login_limit_ip))){
				return [RESULT_ERROR,'该IP禁止登录',url('User/login')];
			}
		}
		$scene=config('config.ADMIN_LOGIN_VERIFY_SWITCH')?"select":"no_captcha";
		$validate=\think\Loader::validate($this->name);
		$validate_result = $validate->scene($scene)->check($data);
        if (!$validate_result) {    
            return [RESULT_ERROR, $validate->getError(), null];
        }

        $user=self::getOneObject(["username"=>$data['username'],"password"=>'###'.md5($data['password'].DATA_ENCRYPT_KEY),'type'=>1]);
        if(empty($user)){
        	return [RESULT_ERROR, '用户名或密码错误', url('User/login')];
        }
        self::saveObject(['last_login_time'=>time(),"id"=>$user['id']]);
        \think\Session::set("backend_author_sign",array("username"=>$data['username'],"userid"=>$user['id']));
		return [RESULT_SUCCESS, '登录成功', url('User/login')];
	}
	public function getUserList($where = [], $field = true, $order = '', $is_paginate = true){
		$paginate_data = $is_paginate ? ['rows' => DB_LIST_ROWS] : false;
		return self::getObject($where, $field, $order, $paginate_data);
	}
}