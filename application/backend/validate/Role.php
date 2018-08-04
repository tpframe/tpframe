<?php
namespace app\backend\validate;

/**
 * 权限验证哭器
 */
class Role extends AdminBase
{
    // 验证规则
    protected $rule = [
        'role_name'              => 'require',
    ];

    // 验证提示
    protected $message = [
        'role_name.require'          => '角色名称不能为空',
    ];

    // 应用场景
    protected $scene = [
        'add'  =>  ['role_name'],
    ];
}