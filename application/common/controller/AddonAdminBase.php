<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\common\controller;
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
    }
    /**
     * 验证用户
     */
    public function valildataAdmin(){
        if(!\think\Session::has("backend_author_sign")){
            $this->redirect('backend/User/login');
        }
    }
}
