<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\backend\controller;
use \tpfcore\Core;

/**
 * 升级程序
 */
class Upgrade extends AdminBase
{
	public function index(){
		$list=Core::loadModel($this->name)->check();
		return $this->fetch("index",[
			'title'=>'tpframe 系统在线升级',
            'list'=>empty($list[2])?[]:$list[2]
        ]);
	}
	public function check(){
		$this->jump(Core::loadModel($this->name)->check());
	}
	//开始升级操作
	public function doup(){
		$list= Core::loadModel($this->name)->check();
		return $this->fetch("doup",[
			"list"=>empty($list) || $list[0]!=0 ? "":json_encode($list[2])
		]);
	}

	public function doupdate(){
		$this->jump(Core::loadModel($this->name)->doupdate($this->param));
	}
}