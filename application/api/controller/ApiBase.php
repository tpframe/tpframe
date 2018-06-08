<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\api\controller;
use \tpfcore\Core;
use app\common\controller\ControllerBase;

class ApiBase extends ControllerBase
{
	public function __construct(){
		parent::__construct();
		// 基础数据验证
		$validate=\think\Loader::validate("ApiBase");
        $validate_result = $validate->scene('apiBase')->check($this->param);
        if (!$validate_result) {
            $this->jump([40000, $validate->getError()]);
        }
	}
}