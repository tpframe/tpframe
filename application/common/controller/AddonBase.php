<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\common\controller;
use think\Request;
use tpfcore\Core;
use tpfcore\helpers\StringHelper;
/**
 * 插件控制器基类
 */
class AddonBase extends ControllerBase
{
    /**
     * 插件基类构造方法
     */
    public function _initialize()
    {
        parent::_initialize();

        // 检查模块是否已经安装
        $request = Request::instance();

        $addon_list = \tpfcore\helpers\FileHelper::get_dir(ADDON_DIR_NAME);

        $out_action=["ajaxdata","addonInfo"];

        if(in_array(MODULE_NAME, $addon_list)&&!in_array(ACTION_NAME, $out_action)){

            $module_name=MODULE_NAME;

            if(!Core::loadModel("Addon","common","logic")->isInstall(['module'=>MODULE_NAME,'status'=>1])){

                $this->tip([-1,"请先安装或启用模块{$module_name}插件后再试",null]);
                
            }
        }
    }
    
    /**
     * 插件模板渲染
     */
    public function addonTemplate($template_name = '',$params=[],$replace=["__THEMES__"=>"/theme/backend/assets"])
    {
        
        $class = get_class($this);

        $arr=explode("\\", $class);

        $module = strtolower($arr[1]);
        
        $view_path = ADDON_DIR_NAME."/{$module}/view/";
        
        $this->assign('static_path', '/' .ADDON_DIR_NAME . "/{$module}/view/static");

        $this->assign('admin_assets_path', '/theme/backend/assets');
        
        $this->view->engine(['view_path' => $view_path]);
        
        echo $this->fetch($template_name,$params,$replace);
    }
    /*
        插件使用说明
    */
    public function doc(){

        echo "该插件开发者未完善使用文档";

    }
    public function ajaxdata(){

        IS_AJAX && $this->jump(Core::loadModel("ControllerBase","common","logic")->ajaxdata($this->param));
        
    }
}
