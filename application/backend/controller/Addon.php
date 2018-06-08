<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */

namespace app\backend\controller;
use tpfcore\Core;
use tpfcore\helpers\StringHelper;
use think\Db;
use think\Config;
/**
 * 插件控制器
 */
class Addon extends AdminBase
{

    /**
     * 插件基类构造方法
     c：controller    控制器
     a：action        操作
     m：module         模块
     */
    public function checkInstall()
    {
        
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
        IS_AJAX || $this->checkInstall();

        $controller_name=isset($this->param['c'])?StringHelper::s_format_class($c):StringHelper::s_format_class($m);

        $action=isset($this->param['a'])?$this->param['a']:"index";

        $class_path = "\\".ADDON_DIR_NAME."\\".$m."\\controller\\".$controller_name;
 
        $controller = new $class_path();

        $result = $controller->$action();

        if(is_array($result)){

            $this->jump($result);

        }
    }

    /**
     * 执行插件安装
     */
    public function addonInstall($catename=null,$name = null)
    {
        Db::startTrans();
        try{
            $strtolower_name = strtolower($name);

            $class_path = "\\".ADDON_DIR_NAME."\\".$strtolower_name."\\".StringHelper::s_format_class($name);

            Core::loadModel($this->name)->executeSql($catename , $strtolower_name, 'install');

            $controller = new $class_path();

            list($status, $message) = $controller->addonInstall();

            Db::commit();

        }catch(\Exception $e){

            Db::rollback();

            $this->jump([RESULT_SUCCESS,"安装失败,失败原因".$e->getMessage()]);

        }

        $this->jump([$status, $message]);
    }

    /**
     * 执行插件卸载
     */
    public function addonUninstall($catename=null,$name = null)
    {

        Db::startTrans();

        try{

            $strtolower_name = strtolower($name);

            $class_path = "\\".ADDON_DIR_NAME."\\".$strtolower_name."\\".StringHelper::s_format_class($name);

            Core::loadModel($this->name)->executeSql($catename , $strtolower_name, 'uninstall');

            $controller = new $class_path();

            list($status, $message) = $controller->addonUninstall();

            Db::commit();

        }catch(\Exception $e){

            Db::rollback();

            $this->jump([RESULT_SUCCESS,"卸载失败,失败原因".$e->getMessage()]);

        }

        $this->jump([$status, $message]);
    }

    /**
     * 插件列表
     */
    public function addonList()
    {

        $listAddonCate = Config::get('addon_class');
      
        $type = input("type")?input("type"):$listAddonCate[0]['type'];

        $this->setTitle('插件列表');
        
        return $this->fetch('addon_list',[

            "list"=>Core::loadModel($this->name)->getAddonList($type),

            "listAddonCate"=> $listAddonCate,

            'type'  => $type

        ]);
    }

    /**
     * 钩子列表
     */
    public function hookList()
    {

        $this->setTitle('钩子列表');

        return $this->fetch('hook_list',[
            "list"=>Core::loadModel($this->name)->getHookList()
        ]);
    }
}
