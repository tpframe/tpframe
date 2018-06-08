<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\common\validate;

/**
 * 基础验证器
 */
class User extends ValidateBase
{
	// 验证规则
    protected $rule = [
        'username'          => 'require|length:3,30',
        'password'          => 'require|length:3,32'
    ];

    // 验证提示
    protected $message = [
        'username.require'    => '用户名不能为空',
        'username.length'     => '用户名长度为3-30个字符之间',
        'password.require'    => '密码不能为空',
        'password.length'     => '密码长度为3-32个字符之间',
    ];

    // 应用场景
    protected $scene = [
        'select'  =>  ['username','password'],
    ];
}
