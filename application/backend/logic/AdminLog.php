<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace app\backend\logic;
use \tpfcore\Core;

class AdminLog extends AdminBase
{
    public function getAdminLog($where = []){
	    return self::getList($where);
    }
}
?>