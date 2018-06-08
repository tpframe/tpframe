<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */

namespace app\frontend\controller;
use tpfcore\Core;
use think\Response;
use tpfcore\helpers\StringHelper;
/**
 * 插件控制器
 */
class Addon extends FrontendBase
{
    
    /**
     * 插件基类构造方法
     c：controller    控制器
     a：action        操作
     m：model         模块
     */
    public function _initialize()
    {
        parent::_initialize();
        
        if(!array_key_exists("m", $this->param)){

            $this->jump([RESULT_ERROR,"该插件模块不存在",null]);            

        }
        $module=$this->param['m'];

        if(!Core::loadModel("Addon")->isInstall(['module'=>$module,'status'=>1])){

            $this->jump([RESULT_ERROR,"请先安装或启用模块{$module}插件后再试",null]);
            
        }
    }

    /**
     * 执行插件控制器
     *  控制模块  参数m
     *  控制器名  参数c来确定
     *  控制器里-操作名  参数a

     * http://www.tpframe.com/addon/execute?c=qq&a=callback&m=login
     */
    public function execute($c = null, $a = null , $m = '' )
    {

        $controller_name=isset($this->param['c'])?StringHelper::s_format_class($c):StringHelper::s_format_class($m);

        $action=isset($this->param['a'])?$a:"index";

        $class_path = "\\".ADDON_DIR_NAME."\\".$m."\\controller\\".$controller_name;
 
        $controller = new $class_path();

        $result = $controller->$action();

        if(is_array($result)){

            $this->jump($result);

        }
    }
}