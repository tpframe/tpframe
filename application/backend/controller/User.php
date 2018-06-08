<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\controller;
use \tpfcore\Core;
use app\common\controller\ControllerBase;

/**
 * Admin控制器基类
 */
class User extends ControllerBase
{
	public function login(){
		\think\Session::has("backend_author_sign") && $this->redirect(url("Index/index"));
		IS_POST && $this->jump(Core::loadModel($this->name)->login($this->param));
        return $this->fetch('login');
	}

	public function loginout(){
		$this->jump(Core::loadModel($this->name)->logout());
	}
}