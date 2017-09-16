<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\model;
use \think\Request;
/**
 * Nav基础模型
 */
class Nav extends AdminBase
{
    protected $auto = ['href'];
    
    protected function setHrefAttr($value)
    {
        $nav_type=Request::instance()->post("nav_type");
        return \think\Request::instance()->post($nav_type);
    }
}
