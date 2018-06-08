<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\api\controller;
use \tpfcore\Core;

class User extends ApiBase
{
	public function login(){
		$this->jump(Core::loadModel($this->name)->login($this->param));
	}
}