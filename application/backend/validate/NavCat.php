<?php
namespace app\backend\validate;

/**
 * 导航分类验证器
 */
class NavCat extends AdminBase
{
    // 验证规则
    protected $rule = [
        'name'              => 'require|unique:NavCat',
    ];

    // 验证提示
    protected $message = [
        'name.require'          => '分类名称不能为空',
        'name.unique'           => '分类名称名已存在',
    ];

    // 应用场景
    protected $scene = [
        'add'  =>  ['name'],
    ];
}