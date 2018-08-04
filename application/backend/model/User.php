<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\model;

use app\common\model\ModelBase;
use \tpfcore\Core;
/**
 * Admin基础模型
 */
class User extends AdminBase
{
    protected $insert = ['grade'=>1,'create_time'];
    protected function setPasswordAttr($value)
    {
        return '###'.md5($value.DATA_ENCRYPT_KEY);
    }
    protected function setCreateTimeAttr($value)
    {
        return time();
    }
}
