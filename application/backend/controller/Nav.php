<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\backend\controller;
use \tpfcore\Core;
class Nav extends AdminBase
{
    public function index()
    {
        return $this->fetch("index",[
            'categorys'=>Core::loadModel($this->name)->getNavList("list",$this->param),
            'listNavCat'=>Core::loadModel("NavCat")->getNavCatList(),
            'cid'=>isset($this->param['cid'])?$this->param['cid']:0
        ]);
    }
    public function edit(){
        IS_POST && $this->jump(Core::loadModel($this->name)->saveNav($this->param));
        return $this->fetch("edit",[
            'list'=>Core::loadModel($this->name)->getNavListByid(['id'=>$this->param['id']]),
            'categorys'=>Core::loadModel($this->name)->getNavList("add",$this->param),
            'listNavCat'=>Core::loadModel("NavCat")->getNavCatList(),
            'categorys_tree'=>Core::loadModel("Category")->getCategoryList("add",$this->param),
            'id'=>$this->param['id']
        ]);
    }
    public function add()
    {
        IS_POST && $this->jump(Core::loadModel($this->name)->saveNav($this->param));
        return $this->fetch("add",[
            'categorys'=>Core::loadModel($this->name)->getNavList("add",$this->param),
            'listNavCat'=>Core::loadModel("NavCat")->getNavCatList(),
            'categorys_tree'=>Core::loadModel("Category")->getCategoryList("add")
        ]);
    }
    public function del()
    {
        die('别乱来');
        $this->jump(Core::loadModel($this->name)->delNav($this->param));
    }
} 
