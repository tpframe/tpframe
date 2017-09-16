<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\frontend\controller;
use \tpfcore\Core;
use app\frontend\model\SlideCat;
use app\frontend\model\Slide;
class Index extends FrontendBase
{
    public function index()
    {
    	return $this->fetch("index");
    }
    public function cases()
    {
    	return $this->fetch("cases",[
            "list"=>Core::loadModel("Posts")->listPosts($this->param,3)
        ]);
    }
    public function about()
    {
    	return $this->fetch("about");
    }
}
