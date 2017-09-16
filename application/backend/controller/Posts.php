<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\backend\controller;
use \tpfcore\Core;
class Posts extends AdminBase
{
    public function index()
    {
        return $this->fetch("index",[
            'list'=>Core::loadModel($this->name)->getPostsList(['isdelete'=>0])
        ]);
    }
    public function edit(){
        IS_POST && $this->jump(Core::loadModel($this->name)->savePosts($this->post));
        return $this->fetch("edit",[
            'categorys'=>Core::loadModel("Category")->getCategoryList("add",$this->param),
            'list'=>Core::loadModel($this->name)->getPostsList(['id'=>$this->param['cid']]),
            'id'=>$this->param['cid']
        ]);
    }
    public function add()
    {
    	IS_POST && $this->jump(Core::loadModel($this->name)->savePosts($this->param));
        return $this->fetch("add",[
            'categorys'=>Core::loadModel("Category")->getCategoryList("add",$this->param)
        ]);
    } 
    public function del()
    {
    	$this->jump(Core::loadModel($this->name)->delPosts($this->param));
    }
} 
