<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\model;

/**
 * Posts基础模型
 */
class Posts extends AdminBase
{
    protected $auto = ['datetime','updatetime'];
    
    protected function setDatetimeAttr($value)
    {
        return time();
    }
    protected function setUpdatetimeAttr($value)
    {
        return strtotime($value);
    }
}
