<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\common\logic;
use think\Db;
use tpfcore\Core;
/**
 * 插件逻辑
 */
class Addon extends LogicBase
{
    // 插件实例
    protected static $instance = [];

    /**
     * 获取插件列表
     */
    public function getAddonList($type)
    {
        // $object_list = $this->getUninstalledList();
        $object_list = $this->getAddonByType($type);

        $list = [];

        $model = Core::loadModel($this->name);

        foreach ($object_list as $object) {

            $addon_info = $object->addonInfo();

            $info = $model->getOneObject(['name' => $addon_info['name']]);

            $addon_info['is_install'] = empty($info) ? DATA_DISABLE : DATA_NORMAL;

            $addon_info['catename']=$object->cate;

            $list[] = $addon_info;

        }
        return $list;
    }

    /**
     * 获取未安装插件列表
     */
    public function getUninstalledList()
    {

        $dir_list = \tpfcore\helpers\FileHelper::get_dir(ADDON_DIR_NAME);
       
        foreach ($dir_list as $key => $value) {

            $sub_dir_list=\tpfcore\helpers\FileHelper::get_dir(ADDON_DIR_NAME."/".$value);

            foreach ($sub_dir_list as $v) {

                $class = "\\".ADDON_DIR_NAME."\\$value\\$v\\".ucfirst($v);

                if (!isset(self::$instance[$class])) {

                    self::$instance[$class] = new $class();
                    
                    self::$instance[$class]->cate=$value;
                }
            }
        }

        return self::$instance;
    }

    /**
     * 获取某个分类下的插件列表
     */
    public function getAddonByType($type)
    {

        $dir_list = \tpfcore\helpers\FileHelper::get_dir(ADDON_DIR_NAME."/".$type);
        
        foreach ($dir_list as $key => $value) {

            $class = "\\".ADDON_DIR_NAME."\\$type\\$value\\".ucfirst($value);

            if (!isset(self::$instance[$class])) {

                self::$instance[$class] = new $class();
                
                self::$instance[$class]->cate=$type;
            }
            
        }

        return self::$instance;
    }

    /**
    * 获取插件分类
    */
    public function getCateAddon(){

        $cate=[];

        $dir_list = \tpfcore\helpers\FileHelper::get_dir(ADDON_DIR_NAME);

        foreach ($dir_list as $key => $value) {

            $config=require ADDON_DIR_NAME.'/'.$value."/config.php";

            $config['plugname']=$value;

            $cate[]=$config;
        }
        return $cate;
    }

    /**
     * 获取钩子列表
     */
    public function getHookList($where = [], $field = true, $order = '', $is_paginate = true)
    {

        $paginate_data = $is_paginate ? ['rows' => DB_LIST_ROWS] : false;

        return Core::loadModel('Hook')->getList($where, $field, $order, $paginate_data);
    }

    /**
     * 执行插件sql
     */
    public function executeSql($catename='' , $name = '', $sql_name = '')
    {

    	$sql_string = file_get_contents(ADDON_PATH .$catename . DS . $name . DS . 'data' . DS . $sql_name.'.sql');

    	$sql = explode(";\n", str_replace("\r", "\n", $sql_string));

        $tablepre=DB_PREFIX;

        $sql = str_replace(" `tpf_", " `{$tablepre}", $sql);

    	foreach ($sql as $value) {
            
            $value=trim($value);

            !empty($value) && Db::execute($value);
    	}
    }
}
