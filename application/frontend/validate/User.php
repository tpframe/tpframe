<?php
namespace app\frontend\validate;
class User extends FrontendBase
{
	// 验证规则
    protected $rule = [
        'username'              => 'require',
        'password'              => 'require',
    ];

    // 验证提示
    protected $message = [
        'username.require'          => '用户名必须',
        'password.require'          => '密码必须',
    ];

    // 应用场景
    protected $scene = [
        'add'  =>  ['username','password']
    ];
}