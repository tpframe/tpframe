<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\frontend\logic;
use \tpfcore\util\Tree;
use \tpfcore\util\Data;
use \tpfcore\Core;

class Slide extends FrontendBase
{
	public function getSlide(){
		$slidecatsql=Core::loadModel("SlideCat")->field("id")->where(['sign'=>"banner"])->buildSql();
		return self::getObject("cid=$slidecatsql","pic,url");
	}
	public function getTpfSlide($data){
		return self::getList($data);
	}
}