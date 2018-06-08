<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\common\controller;
use think\Request;
use tpfcore\Core;

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

        $out_module=["backend","frontend"];
        if(!in_array(MODULE_NAME, $out_module)){
            $module_name=isset($this->param['m'])?$this->param['m']:MODULE_NAME;
            /*echo "当前链接：".$request->url(true) .";当前模块：".$module_name."<br/>";
            echo '开始进行是否安装验证<br/>';*/
            if(!Core::loadModel("Addon","common","logic")->isInstall(['module'=>MODULE_NAME,'status'=>1])){

                $this->jump([RESULT_ERROR,"请先安装或启用模块{$module_name}插件后再试",null]);
                
            }
        }
    }
    
    /**
     * 插件模板渲染
     */
    public function addonTemplate($template_name = '',$params=[])
    {
        
        $class = get_class($this);

        $arr=explode("\\", $class);


        $cate_name = strtolower($arr[1]);
        
        $view_path = ADDON_DIR_NAME."/{$cate_name}/view/";
        
        $this->assign('static_path', '/' .ADDON_DIR_NAME . "/{$cate_name}/view/static");

        $this->assign('admin_assets_path', '/theme/backend/assets');

        $this->assign('catename',$cate_name);
        
        $this->view->engine(['view_path' => $view_path]);
        
        echo $this->fetch($template_name,$params);
    }
    /*
        插件使用说明
    */
    public function doc(){
        echo "该插件开发者未完善使用文档";
    }
    public function ajaxdata(){
        IS_AJAX && $this->jump(Core::loadModel("AddonBase","common","logic")->ajaxdata($this->param));
    }
}
