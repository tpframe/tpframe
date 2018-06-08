<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\service;
use \tpfcore\Core;
/**
 * 导航管理
 */
class Menu extends AdminServiceBase
{
	public function getMenuList($type="list",$data=[]){
		if($type=="list")
			return Core::loadModel($this->name)->getMenuList($data);
		else
			return Core::loadModel($this->name)->getTreeMenu($data);
	}
	public function saveMenu($data){
		return Core::loadModel($this->name)->saveMenu($data);	
	}
	public function getMenuListByid($data){
		return Core::loadModel($this->name)->getMenuListByid($data);
	}
	public function getMenuArrTree($where,$filter=false,$returnarr=false){
		return Core::loadModel($this->name)->getMenuArrTree($where,$filter,$returnarr);	
	}
	public function delMenu($data){
		return Core::loadModel($this->name)->delMenu($data);
	}
}
