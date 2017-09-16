<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\frontend\controller;
use \think\Request;
use \tpfcore\Core;
class Posts extends FrontendBase
{
    public function index()
    {
    	return $this->fetch("index",[
            "list"=>Core::loadModel($this->name)->listPosts($this->param),
            'listChild'=>Core::loadModel("Category")->getChilds()
        ]);
    }
    public function show()
    {
    	return $this->fetch("show",[
    		"id"=>isset($this->param['id'])?$this->param['id']:0,
            'listChild'=>Core::loadModel("Category")->getChilds()
        ]);
    }
}
