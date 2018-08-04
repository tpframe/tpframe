<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\common\controller;
use tpfcore\Core;
/**
 * 插件后台控制器基类
 */
class AddonAdminBase extends AddonBase
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
        define('ADDON_ADMIN_INC', true);
    }
    /**
     * 验证用户
     */
    public function valildataAdmin(){
        if(!\think\Session::has("backend_author_sign")){
            $this->redirect(url('backend/User/login'));
        }
    }
    /**
     * 验证权限
     */
    public function valildataPrivs(){
        $action=CONTROLLER_NAME.ACTION_NAME;
        $menu=Core::loadModel("Menu","backend","logic")->getMenuArrTree(['display'=>1],true,true);
        $privs=[];$outPrivs=["Indexmain","Indexindex"];
        foreach ($menu as $key => $value) {
            $privs[]=$value['controller'].strtolower($value['action']);
        }
        if(\think\Session::get("backend_author_sign")['userid']!=1 && !in_array($action, $outPrivs) && !in_array($action, array_unique($privs))){
            $this->jump([RESULT_ERROR, '你没有权限进行此操作', null]);
        }
    }
}
