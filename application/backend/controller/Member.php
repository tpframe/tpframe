<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\controller;
use \tpfcore\Core;
use app\common\controller\ControllerBase;

/**
 * Member控制器基类
 */
class Member extends AdminBase
{
	/*
		个人信息
	*/
	public function userinfo(){
		IS_POST && $this->jump(Core::loadModel($this->name)->upUserInfo($this->param));
        return $this->fetch('userinfo',['list'=>Core::loadModel($this->name)->getInfo(['id'=>\think\Session::get("backend_author_sign")['userid']])]);
	}
	/*
		修改密码
	*/
	public function uppwd(){
		IS_POST && $this->jump(Core::loadModel($this->name)->uppwd($this->param));
        return $this->fetch('uppwd');
	}
	/*
		会员管理
	*/
	public function index(){
		return $this->fetch("index",[
            'list'=>Core::loadModel($this->name)->getUserList(['grade'=>0])
        ]);
	}
	/*
		管理员管理
	*/
	public function admin(){
		return $this->fetch("admin",[
            'list'=>Core::loadModel($this->name)->getUserList(['grade'=>1])
        ]);
	}
	/*
		添加管理员
	*/
	public function add(){
		IS_POST && $this->jump(Core::loadModel($this->name)->addUser($this->param));
		return $this->fetch("add");
	}
	/*
		编辑管理员
	*/
	public function edit(){
		IS_POST && $this->jump(Core::loadModel($this->name)->editUser($this->param));
		return $this->fetch("edit",[
			'id'=>$this->param['id'],
			"list"=>Core::loadModel($this->name)->getUserList($this->param)
		]);
	}
	/*
		拉黑用户操作
	*/
	public function ban(){
		$this->jump(Core::loadModel($this->name)->ban($this->param));
	}
	/*
		权限操作
	*/
	public function priv(){
		IS_POST && $this->jump(Core::loadModel($this->name)->priv($this->param));
		return $this->fetch("priv",[
			'listUser'=>Core::loadModel("Member")->getUserList(['id'=>$this->param['id']],"id,username,privs"),
			'listPrivs'=>Core::loadModel("Menu")->getMenuArrTree(['type'=>1])
		]);
	}
}