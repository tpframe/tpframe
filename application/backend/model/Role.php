<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\model;

use app\common\model\ModelBase;

/**
 * Rple基础模型
 */
class Role extends AdminBase
{
    protected function setPrivsAttr($value)
    {
        return empty($value)?$value:implode(",", $value);
    }
}
