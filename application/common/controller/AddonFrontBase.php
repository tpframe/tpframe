<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\common\controller;
use tpfcore\Core;
/**
 * 插件前台控制器基类
 */
class AddonFrontBase extends AddonBase
{
    /**
     * 构造方法
     */
    public function _initialize()
    {
        // 执行父类构造方法
        parent::_initialize();

        if(config("config.WEB_SITE_CLOSE")){

            $this->jump([RESULT_ERROR,"网站维护中,请稍后再试！"]);
            
        }
    }
}
