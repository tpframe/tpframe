<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\model;

/**
 * Setting基础模型
 */
class Setting extends AdminBase
{
    protected function setOptionsAttr($value)
    {
        return \tpfcore\helpers\Json::encode($value);
    }
}
