<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\backend\controller;
use \tpfcore\Core;
class Menu extends AdminBase
{
    public function index()
    {
        return $this->fetch("index",[
            'categorys'=>Core::loadModel($this->name)->getMenuList()
        ]);
    }
    public function edit(){
        IS_POST && $this->jump(Core::loadModel($this->name)->saveMenu($this->param));
        return $this->fetch("edit",[
            'list'=>Core::loadModel($this->name)->getMenuListByid(['id'=>$this->param['id']]),
            'categorys'=>Core::loadModel($this->name)->getMenuList("add",$this->param),
            'id'=>$this->param['id']
        ]);
    }
    public function add()
    {
    	IS_POST && $this->jump(Core::loadModel($this->name)->saveMenu($this->param));
        return $this->fetch("add",[
            'categorys'=>Core::loadModel($this->name)->getMenuList("add",$this->param)
        ]);
    }
    public function del()
    {
    	$this->jump(Core::loadModel($this->name)->delMenu($this->param));
    }
} 
