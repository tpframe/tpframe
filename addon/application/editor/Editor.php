<?php
namespace addon\application\editor;

use app\common\controller\AddonBase;

use app\common\dao\AddonInterface;

/**
 * 富文本编辑器插件
 */
class Editor extends AddonBase implements AddonInterface
{
    
    /**
     * 实现钩子
     */
    public function ArticleEditor($param = [])  
    {
        $this->addonTemplate('index/index',[
            "addons_data"=>$param,
            "addons_config"=>$this->addonConfig()
        ]);
    }
    
    /**
     * 插件安装
     */
    public function addonInstall()
    {
        
        return [RESULT_SUCCESS, '编辑器安装成功'];
    }
    
    /**
     * 插件卸载
     */
    public function addonUninstall()
    {
        
        return [RESULT_SUCCESS, '编辑器卸载成功'];
    }
    
    /**
     * 插件基本信息
     */
    public function addonInfo()
    {
        
        return ['name' => 'Editor', 'title' => '文本编辑器', 'describe' => '富文本编辑器', 'author' => 'yaosean', 'version' => '1.0' , "ext" => false];
    }
    
    /**
     * 插件配置信息
     */
    public function addonConfig()
    {
        
        $addons_config['editor_height'] = '300px';
        $addons_config['editor_resize_type'] = 1;
        
        return $addons_config;
    }
}
