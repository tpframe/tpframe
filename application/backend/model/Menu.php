<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\model;

/**
 * Menu基础模型
 */
class Menu extends AdminBase
{
    protected $resultSetType = 'collection';
    
    protected $insert = ['controller','action'];
    
    protected function setControllerAttr($value)
    {
        if(empty($value)) return "Index";
        else return $value;
    }
    protected function setActionAttr($value)
    {
        if(empty($value)) return "index";
        else return $value;
    }
}
