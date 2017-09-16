<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\service;
use \tpfcore\Core;
/**
 * 分类
 */
class Posts extends AdminServiceBase
{
	public function savePosts($data){
		return Core::loadModel($this->name)->savePosts($data);
	}
	public function delPosts($data){
		return Core::loadModel($this->name)->delPosts($data);
	}
	public function getPostsList($where=[]){
		return Core::loadModel($this->name)->getPostsList($where);
	}
}
