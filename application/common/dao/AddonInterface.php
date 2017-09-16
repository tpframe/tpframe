<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\common\dao;
/**
 * 插件接口
 */
interface AddonInterface
{  
    /**
     * 插件安装
     */
    public function addonInstall();
    
    /**
     * 插件卸载
     */
    public function addonUninstall();
    
    /**
     * 插件信息
     */
    public function addonInfo();
    
    /**
     * 插件配置信息
     */
    public function addonConfig();
}
