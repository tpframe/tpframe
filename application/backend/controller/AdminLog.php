<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace app\backend\controller;
use \tpfcore\Core;
class AdminLog extends AdminBase
{
    public function index(){
        return $this->fetch('index',[
            "list"=>Core::loadModel($this->name)->getAdminLog([
                "paginate"  =>['rows' => DB_LIST_ROWS],
            ])
        ]);
    }
}
?>