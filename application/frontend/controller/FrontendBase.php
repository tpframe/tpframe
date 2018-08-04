<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\frontend\controller;
use \tpfcore\Core;
use app\common\controller\ControllerBase;

class FrontendBase extends ControllerBase
{
	 public function _initialize()
    {
        parent::_initialize();
        if(config("config.WEB_SITE_CLOSE")){
        	$this->jump([RESULT_ERROR,"网站维护中,请稍后再试！"]);
        }
    }
}