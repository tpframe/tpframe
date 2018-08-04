<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\common\controller;
use tpfcore\Core;
/**
 * 插件前台控制器基类
 */
class ErrorController extends ControllerBase
{
    public function index(){
        $this->tip([0,"你访问的页面不存在",null]);
    }
}