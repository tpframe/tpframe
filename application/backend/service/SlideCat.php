<?php
namespace app\backend\service;
use \tpfcore\Core;
/**
 * 轮播分类
 */
class SlideCat extends AdminServiceBase
{
    public function getSlideCatList($where){
        return Core::loadModel($this->name)->getSlideCatList($where);
    }
    public function addSlideCat($data){
        return Core::loadModel($this->name)->addSlideCat($data);
    }
    public function delSlideCat($data){
        return Core::loadModel($this->name)->delSlideCat($data);
    }
    public function editSlideCat($data){
        return Core::loadModel($this->name)->editSlideCat($data);
    }
}
?>