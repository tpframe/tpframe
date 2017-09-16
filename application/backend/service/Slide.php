<?php
namespace app\backend\service;
use \tpfcore\Core;
/**
 * 轮播分类
 */
class Slide extends AdminServiceBase
{
    public function getSlideList($data=null){
        return Core::loadModel($this->name)->getSlideList($data);
    }
    public function addSlide($data){
        return Core::loadModel($this->name)->addSlide($data);
    }
    public function delSlide($data){
        return Core::loadModel($this->name)->delSlide($data);
    }
    public function editSlide($data){
        return Core::loadModel($this->name)->editSlide($data);
    }
}
?>