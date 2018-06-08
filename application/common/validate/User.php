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
        'password'          => 'require|length:3,30',
        'captcha|验证码'    =>'require|captcha'
    ];

    // 验证提示
    protected $message = [
        'username.require'    => '用户名不能为空',
        'username.length'     => '用户名长度为3-30个字符之间',
        'username.unique'     => '用户名已存在',
        'password.require'    => '密码不能为空',
        'password.length'     => '密码长度为3-30个字符之间',
        'captcha.require'      => '验证码不能为空',    
    ];

    // 应用场景
    protected $scene = [
        'select'  =>  ['username','password','captcha'],
    ];
}
