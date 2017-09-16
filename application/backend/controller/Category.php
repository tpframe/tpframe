<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\backend\controller;
use \tpfcore\Core;
class Category extends AdminBase
{
    public function index()
    {
        return $this->fetch("index",[
            'categorys'=>Core::loadModel($this->name)->getCategoryList()
        ]);
    }
    public function edit(){
        IS_POST && $this->jump(Core::loadModel($this->name)->saveCategory($this->param));
        return $this->fetch("edit",[
            'list'=>Core::loadModel($this->name)->getCategoryListByid(['id'=>$this->param['id']]),
            'categorys'=>Core::loadModel($this->name)->getCategoryList("add",$this->param),
            'id'=>$this->param['id']
        ]);
    }
    public function add()
    {
        IS_POST && $this->jump(Core::loadModel($this->name)->saveCategory($this->param));
        return $this->fetch("add",[
            'categorys'=>Core::loadModel($this->name)->getCategoryList("add",$this->param)
        ]);
    }
    public function del()
    {
        die('别乱来');
        $this->jump(Core::loadModel($this->name)->delCategory($this->param));
    }
} 
