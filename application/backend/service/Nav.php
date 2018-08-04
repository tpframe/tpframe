<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\service;
use \tpfcore\Core;
/**
 * 导航管理
 */
class Nav extends AdminServiceBase
{
	public function getNavList($type="list",$data=[]){
		if($type=="list")
			return Core::loadModel($this->name)->getNavList($data);
		else
			return Core::loadModel($this->name)->getTreeNav($data);
	}
	public function saveNav($data){
		return Core::loadModel($this->name)->saveNav($data);	
	}
	public function getNavListByid($data){
		return Core::loadModel($this->name)->getNavListByid($data);
	}
	public function getNavArrTree($where,$filter=false,$returnarr=false){
		return Core::loadModel($this->name)->getNavArrTree($where,$filter,$returnarr);	
	}
	public function delNav($data){
		return Core::loadModel($this->name)->delNav($data);
	}
}
