<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace app\backend\logic;
use \tpfcore\Core;

class Statistics extends AdminBase
{	

	// 未审核的文章数
    public function getUncheckPostsNumber(){

    	if($this->checkAddonByName("cms")==0) return 0;

    	return Core::loadAddonModel("Posts","cms","controller")->getStatistics(["ischeck"=>0]);

    }

    // 订单数据 
    public function getOrderNumber($where=[]){
    	
    	if($this->checkAddonByName("mall")==0) return 0;

    	return Core::loadAddonModel("Order","mall","controller")->getStatistics($where);
    }

    private function checkAddonByName($addon_name=""){
    	return Core::loadModel("Addon")->getStatistics(["module"=>$addon_name,"status"=>1]);
    }



}
?>