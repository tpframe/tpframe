<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\frontend\logic;
use \tpfcore\util\Tree;
use \tpfcore\util\Data;
use \tpfcore\Core;
/**
 *  文章逻辑
 */
class Posts extends FrontendBase
{
	public function listPosts($data , $limit){
		if(!$data) return null;
		$data=implode(",", $data);
		$paginate_data = ['rows' => $limit];
		return self::getObject("cateid in ($data)", true, "", $paginate_data);
	}
	public function getPosts($limit=1,$where="1=1"){
		return Core::loadModel("Posts")->order("thumb desc")->where($where)->limit($limit)->select();
	}

	public function countPost($id){
		$Category=Core::loadModel("Category",'','logic');
		$Category->ids=[];
		$ids=$Category->getChildIds($id);
		$ids[]=$id;
		return self::getStatistics("cateid in(".implode(",", $ids).")");
	}
	public function getPostById($id){
		$result=self::getOneObject(["id"=>$id]);
		return $result?$result->toArray():"";
	}
	public function getTpfPosts($data){
		return self::getList($data);
	}
	public function updateView($id){
		Core::loadModel("Posts")->where(["id"=>$id])->setInc("view");
	}
	/*
		查询上下一篇文章
	*/
	public function preNextPost($parentid,$id,$option="next"){
		$Category=Core::loadModel("Category",'','logic');
		$Category->ids=[];
		$ids=$Category->getChildIds($parentid);
		$ids[]=$id;
		if($option=="next"){
			$list=Core::loadModel("Posts")->where("cateid in(".implode(",", $ids).") and id>$id")->order("id asc")->limit(1)->select();
			$link=$list?"<a href=\"/frontend/posts/show/id/{$list[0]->id}\">{$list[0]->title}</a>":"没有下一篇";
		}else{
			$list=Core::loadModel("Posts")->where("cateid in(".implode(",", $ids).") and id<$id")->order("id desc")->limit(1)->select();
			$link=$list?"<a href=\"/frontend/posts/show/id/{$list[0]->id}\">{$list[0]->title}</a>":"没有上一篇";
		}
		return $link;
	}
}