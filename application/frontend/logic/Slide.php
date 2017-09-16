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
		$slidecatsql=Core::loadModel("SlideCat")->field("cid")->where(['cat_idname'=>"banner"])->buildSql();
		return self::getObject("slide_cid=$slidecatsql","slide_pic,slide_url");
	}
}