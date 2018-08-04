<?php
namespace app\frontend\controller;
use \tpfcore\Core;
class ErrorController extends FrontendBase
{
    public function index(){
        $this->tip([0,"你访问的页面不存在",null]);
    }
}