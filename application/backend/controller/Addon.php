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
     * 执行插件安装
     */
    public function addonInstall($name = null)
    {
        $strtolower_name = strtolower($name);

        $class_path = "\\".ADDON_DIR_NAME."\\".$strtolower_name."\\".StringHelper::s_format_class($name);

        $controller = new $class_path();

        $config=$controller->addonInfo();

        if(isset($config['depend']) && $config['depend']){

            $depend_addon_list=explode(",", $config['depend']);

            foreach ($depend_addon_list as $key => $value) {

                if(!Core::loadModel($this->name)->isInstall(['module'=>$value])){

                    $this->jump([RESULT_ERROR,"该插件依赖于{$value}插件,请先安装".$value."插件后再试!"]);

                }

            }
            
        }
        Db::startTrans();
        try{
            
            Core::loadModel($this->name)->executeSql($strtolower_name, 'install');

            list($status, $message) = $controller->addonInstall();

            Db::commit();

        }catch(\Exception $e){

            Db::rollback();

            $this->jump([RESULT_ERROR,"操作失败,失败原因".$e->getMessage()]);

        }

        $this->jump([$status, $message]);
    }

    /**
     * 执行插件卸载
     */
    public function addonUninstall($name = null)
    {

        Db::startTrans();

        try{

            $strtolower_name = strtolower($name);

            $class_path = "\\".ADDON_DIR_NAME."\\".$strtolower_name."\\".StringHelper::s_format_class($name);

            Core::loadModel($this->name)->executeSql($strtolower_name, 'uninstall');

            $controller = new $class_path();

            list($status, $message) = $controller->addonUninstall();

            Db::commit();

        }catch(\Exception $e){

            Db::rollback();

            $this->jump([RESULT_SUCCESS,"操作失败,失败原因".$e->getMessage()]);

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
