<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */

namespace app\backend\controller;
use tpfcore\Core;
use tpfcore\helpers\StringHelper;
/**
 * 插件控制器
 */
class Addon extends AdminBase
{

    /**
     * 执行插件控制器
     * catename  插件分类  控制模块  参数m
     * addon_name  插件名  根据控制器来确定
     * controller_name  控制器名  参数c来确定
     * action_name  控制器里-操作名  参数a
     * http://www.tpframe.com/addon/execute?c=qq&a=callback&m=login
     */
    public function execute($c = null, $a = null , $m = '')
    {

        $controller_name=StringHelper::s_format_class($c);

        $class_path = "\\".ADDON_DIR_NAME."\\$m\\".$c."\controller\\".$controller_name;

        $controller = new $class_path();

        $controller->$a();
    }

    /**
     * 执行插件安装
     */
    public function addonInstall($catename=null,$name = null)
    {

        $strtolower_name = strtolower($name);

        $class_path = "\\".ADDON_DIR_NAME."\\".$catename."\\".$strtolower_name."\\".$name;

        Core::loadModel($this->name)->executeSql($catename , $strtolower_name, 'install');

        $controller = new $class_path();

        list($status, $message) = $controller->addonInstall();

        $this->jump($status, $message);
    }

    /**
     * 执行插件卸载
     */
    public function addonUninstall($catename=null,$name = null)
    {

        $strtolower_name = strtolower($name);

        $class_path = "\\".ADDON_DIR_NAME."\\".$catename."\\".$strtolower_name."\\".$name;

        Core::loadModel($this->name)->executeSql($catename , $strtolower_name, 'uninstall');

        $controller = new $class_path();

        list($status, $message) = $controller->addonUninstall();

        $this->jump($status, $message);
    }

    /**
     * 插件列表
     */
    public function addonList()
    {
        $listAddonCate = Core::loadModel($this->name)->getCateAddon();
      
        $type = input("type")?input("type"):$listAddonCate[0]['plugname'];

        $this->setTitle('插件列表');
        
        return $this->fetch('addon_list',[

            "list"=>Core::loadModel($this->name)->getAddonList($type),

            "listAddonCate"=>$listAddonCate ,

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
