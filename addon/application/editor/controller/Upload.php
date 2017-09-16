<?php
namespace addon\application\editor\controller;

use app\common\controller\AddonBase;

/**
 * 编辑器插件上传控制器
 */
class Upload extends AddonBase
{
    /**
     * 图片上传
     */
    public function pictureUpload()
    {
        
        $UploadLogic = new \addon\application\editor\logic\Upload();
        
        $result = $UploadLogic->pictureUpload();
        
        exit(json_encode($result));
    }
    
   
}
