<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\common\logic;
use think\Db;
use tpfcore\Core;
use tpfcore\helpers\StringHelper;
/**
 * 插件逻辑
 */
class Addon extends LogicBase
{
    // 插件实例
    protected static $instance = [];

    public function getAddon($data=[]){
        return self::getList($data);
    }
    /**
     * 获取插件列表
     */
    public function getAddonList($type)
    {
        $object_list = $this->getAddonByType($type);

        $list = [];

        foreach ($object_list as $object) {

            $addon_info = $object->addonInfo();

            $info = self::getOneObject(['module' => $addon_info['name']],"id,status");

            $addon_info['is_install'] = empty($info) ? DATA_DISABLE : DATA_NORMAL;

            $addon_info['status'] = empty($info) ? 0 : $info['status'];

            $addon_info['id'] = empty($info) ? 0 : $info['id'];

            $list[] = $addon_info;

        }
        return $list;
    }

    /**
     * 获取某个分类下的插件列表
     */
    public function getAddonByType($type)
    {

        $dir_list = \tpfcore\helpers\FileHelper::get_dir(ADDON_DIR_NAME);
        
        foreach ($dir_list as $key => $value) {

            $class = "\\".ADDON_DIR_NAME."\\$value\\".StringHelper::s_format_class($value);

            if (!isset(self::$instance[$class])) {

                $confEntity=new $class();

                if($confEntity->addonInfo()['type']==$type){

                    self::$instance[$class] = $confEntity;

                }
            }
            
        }

        return self::$instance;
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
    public function executeSql($name = '', $sql_name = '')
    {

        $sql_string = file_get_contents(ADDON_PATH . $name . DS . 'data' . DS . $sql_name.'.sql');

        $sql = explode(";\n", str_replace("\r", "\n", $sql_string));

        $tablepre=DB_PREFIX;

        $sql = str_replace(" `tpf_", " `{$tablepre}", $sql);

        foreach ($sql as $value) {
            
            $value=trim($value);

            !empty($value) && Db::execute($value);
        }
    }
    /**
    * 判断插件是否已经正常安装
    */
    public function isInstall($where){

        $result=self::getOneObject($where);

        if($result && count($result->toArray())>0) return true;

        return false;
        
    }
}
