<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\model;

use app\common\model\ModelBase;

/**
 * Admin基础模型
 */
class User extends AdminBase
{
    protected $auto = ['password','privs'];
    protected $insert = ['grade'=>1,'create_time'];
    protected function setPasswordAttr($value)
    {
        return md5($value);
    }
    protected function setCreateTimeAttr($value)
    {
        return time();
    }
    protected function setPrivsAttr($value)
    {
        return empty($value)?$value:implode(",", $value);
    }
}
