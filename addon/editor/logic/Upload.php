<?php
namespace addon\editor\logic;

/**
 * 编辑器插件上传逻辑
 */
class Upload
{
    /**
     * 图片上传
     */
    public function pictureUpload()
    {
        $object = request()->file('imgFile')->move(UPLOAD_PATH . 'editor');
        $result  = ['error' => DATA_DISABLE, 'url' => '']; 
        if ($object) {
            
            $save_name = $object->getSaveName();
            
            $picture_dir_name = substr($save_name, 0, strrpos($save_name, DS));
            
            $filename = $object->getFilename();
            
            $result['url'] = UPLOAD_PATH_RELATIVE . "editor/".$picture_dir_name."/".$filename;
        } else {
            $result['error'] = DATA_NORMAL;
            $result['message'] = $object->getError();
        }
        return $result;
    }
}
