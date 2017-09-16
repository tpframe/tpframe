<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace app\backend\controller;
use \tpfcore\Core;
class Slide extends AdminBase
{
    public function index()
    {
        $this->assign('slide', Core::loadModel($this->name)->getSlideList());
        return $this->fetch("index");
    }
    public function add()
    {
        IS_POST  && $this->jump(Core::loadModel($this->name)->addSlide($this->param));
        $this->assign('categorys', Core::loadModel("SlideCat")->getSlideCatList($this->param));
        return $this->fetch("add");
    }
    public function edit(){
        
        IS_POST && $this->jump(Core::loadModel($this->name)->editSlide($this->param));
        $list = Core::loadModel($this->name)->getSlideList($this->param);
        foreach($list as $k=>$v){
            $list = $v;
        }
        $this->assign('edit_slide',$list);
        return $this->fetch("edit");
    }
    public function del()
    {
        $this->jump(Core::loadModel($this->name)->delSlide($this->param));
    }
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('imgFile');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH .DS.'data'.DS.'uploads'.DS);
        if($info){
            // 成功上传后 获取上传信息
           $file_url = '/data/uploads/'.date("Ymd",time()).'/'.$info->getFilename();
           
           echo json_encode(array('error' => 0, 'url' => $file_url));
        }else{
            // 上传失败获取错误信息
          echo  $file->getError();
        }
    }
}
?>