<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\api\service;

use app\common\service\ServiceBase;
use tpfcore\Core;

/**
 * User基础服务
 */
class User extends ApiBase
{
	public function login($data){
		// 用户登录时的数据验证
		$validate=\think\Loader::validate($this->name);
        $validate_result = $validate->scene('login')->check($data);
        if (!$validate_result) {
            return [40000, $validate->getError()];
        }
        //调用逻辑处理
        return Core::loadModel($this->name)->login($data);
	}
}
