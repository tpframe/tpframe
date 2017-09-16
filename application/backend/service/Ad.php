<?php
namespace app\backend\service;
use \tpfcore\Core;
/**
 * 广告
 */
class Ad extends AdminServiceBase
{
    public function getAdList(){
        return Core::loadModel($this->name)->getAdList();
    }
    public function addAd($data){
        return Core::loadModel($this->name)->addAd($data);
    }
}
?>