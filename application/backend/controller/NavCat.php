<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\backend\controller;
use \tpfcore\Core;
class NavCat extends AdminBase
{
    public function index()
    {
        return $this->fetch("index",[
            'list'=>Core::loadModel($this->name)->getNavCatList()
        ]);
    }
    public function edit(){
        IS_POST && $this->jump(Core::loadModel($this->name)->saveNavCat($this->param));
        return $this->fetch("edit",[
            'list'=>Core::loadModel($this->name)->getNavCatList(['id'=>$this->param['id']]),
            'id'=>$this->param['id']
        ]);
    }
    public function add()
    {
    	IS_POST && $this->jump(Core::loadModel($this->name)->saveNavCat($this->param));
        return $this->fetch("add");
    }
    public function del()
    {
    	$this->jump(Core::loadModel($this->name)->delNavCat($this->param));
    }
} 
