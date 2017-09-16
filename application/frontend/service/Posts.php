<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\frontend\service;
use \tpfcore\Core;
/**
 * 文章服务类
 */
class Posts extends FrontendServiceBase
{
	public function listPosts($data,$limit=DB_LIST_ROWS){
		if(empty($data["cid"])){
			return null;
		}
		$arr=Core::loadModel("Category")->getChildIds($data['cid']);
		$arr[]=$data['cid'];
		return Core::loadModel($this->name)->listPosts($arr,$limit);
	}
}
