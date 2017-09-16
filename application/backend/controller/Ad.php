<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace app\backend\controller;
use \tpfcore\Core;
class Ad extends AdminBase
{
    public function index(){
        $this->assign('ad',Core::loadModel($this->name)->getAdList());
       return $this->fetch('index');
    }
    public function add(){
        IS_POST && $this->jump(Core::loadModel($this->name)->addAd($this->param));
        return $this->fetch('add');
    }
    public function edit(){
        
    }
}
?>