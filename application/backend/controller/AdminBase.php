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
class AdminBase extends ControllerBase
{
	/**
     * 构造方法
     */
    public function _initialize()
    {
        // 执行父类构造方法
        parent::_initialize();
        $this->valildataAdmin();
        $this->valildataPrivs();
    }
    /**
     * 验证用户
     */
    public function valildataAdmin(){
    	if(!\think\Session::has("backend_author_sign")){
    		$this->redirect('User/login');
    	}
    }
    /**
     * 验证权限
     */
    public function valildataPrivs(){
        $action=strtolower(MODULE_NAME.CONTROLLER_NAME.ACTION_NAME);
        $menu=Core::loadModel("Menu","backend","logic")->getMenuArrTree(['type'=>1],true,true);
        $privs=[];$outPrivs=["backendindexmain","backendindexindex"];
        foreach ($menu as $key => $value) {
            $privs[]=strtolower($value['module'].$value['controller'].$value['action']);
        }

        if(\think\Session::get("backend_author_sign")['userid']!=1 && !in_array($action, $outPrivs) && !in_array($action, array_unique($privs))){
            $this->jump([RESULT_ERROR, '你没有权限进行此操作', null]);
        }
    }

    public function ajaxdata(){
        IS_AJAX && $this->jump(Core::loadModel("AdminBase")->ajaxdata($this->param));
    }
}