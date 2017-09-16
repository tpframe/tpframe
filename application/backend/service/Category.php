<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\service;
use \tpfcore\Core;
/**
 * 分类服务
 */
class Category extends AdminServiceBase
{
	public function getCategoryList($type="list",$data=[]){
		if($type=="list")
			return Core::loadModel($this->name)->getCategoryList($data);
		else
			return Core::loadModel($this->name)->getTreeCategory($data);
	}
	public function saveCategory($data){
		return Core::loadModel($this->name)->saveCategory($data);	
	}
	public function getCategoryListByid($data){
		return Core::loadModel($this->name)->getCategoryListByid($data);
	}
}
