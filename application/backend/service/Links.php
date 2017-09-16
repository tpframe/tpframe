<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\service;
use \tpfcore\Core;
/**
 * 友情链接
 */
class Links extends AdminServiceBase
{
	public function saveLinks($data){
		return Core::loadModel($this->name)->saveLinks($data);
	}
	public function delLinks($data){
		return Core::loadModel($this->name)->delLinks($data);
	}
	public function getLinksList($where=[]){
		return Core::loadModel($this->name)->getLinksList($where);
	}
}
