<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace app\backend\controller;
use \tpfcore\Core;
class Role extends AdminBase
{
    public function index(){
        $this->assign('list',Core::loadModel($this->name)->getRoleList());
        return $this->fetch('index');
    }
    public function add(){
        IS_POST && $this->jump(Core::loadModel($this->name)->addRole($this->param));
        return $this->fetch('add',[
        ]);
    }
    public function edit(){
        IS_POST && $this->jump(Core::loadModel($this->name)->editRole($this->param));
        return $this->fetch('add',[
            'id'=>$this->param['id'],
            'list'=>Core::loadModel($this->name)->getRoleList($this->param),
        ]);
    }
    public function del(){
        $this->jump(Core::loadModel($this->name)->del($this->param));
    }
}
?>