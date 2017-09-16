<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace app\backend\controller;
use \tpfcore\Core;
class SlideCat extends AdminBase
{
    public function index()
    {
        $this->assign('slidecat', Core::loadModel($this->name)->getSlideCatList($this->param));
        return $this->fetch("index");
    }
    public function add()
    {
        IS_POST  && $this->jump(Core::loadModel($this->name)->addSlideCat($this->param));
        return $this->fetch("add");
    }
    public function edit(){
        IS_POST && $this->jump(Core::loadModel($this->name)->editSlideCat($this->param));
        $list = Core::loadModel("SlideCat")->getSlideCatList($this->param);
        foreach($list as $k=>$v){
            $list = $v;
        }
        $this->assign('edit_slide',$list);
        return $this->fetch("edit");
    }
    public function del()
    {
        $this->jump(Core::loadModel($this->name)->delSlideCat($this->param));
    }
}
?>