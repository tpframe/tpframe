<?php
namespace app\backend\validate;

class Menu extends AdminBase
{
    // 验证规则
    protected $rule = [
        'name'              => 'require',
        'module'              => 'require',
        'controller'              => 'require',
        'action'              => 'require',
    ];

    // 验证提示
    protected $message = [
        'name.require'          => '名称不能为空',
        'module.require'          => '模块不能为空',
        'controller.require'          => '控制器不能为空',
        'action.require'          => '操作不能为空'
    ];

    // 应用场景
    protected $scene = [
        'add'  =>  ['name','module','controller','action'],
    ];
}