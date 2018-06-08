<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\api\validate;

use app\common\validate\ValidateBase;

/**
 * api基础验证器
 */
class ApiBase extends ValidateBase 
{
	// 验证规则
    protected $rule = [
        'token'                    => 'require',
        'app_version'              => 'require|=:1.0.0',
        'api_version'              => 'require|=:1.0',

    ];

    // 验证提示
    protected $message = [
        'token.require'                 => '唯一标识不能为空',
        'app_version.require'           => 'app版本号不能为空',
        'api_version.require'           => 'api版本号不能为空',
    ];

    // 应用场景
    protected $scene = [
        'ApiBase'  =>  ['token','app_version','api_version'],
    ];
}
