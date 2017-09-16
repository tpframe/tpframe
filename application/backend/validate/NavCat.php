<?php
namespace app\common\validate;

/**
 * 导航分类验证器
 */
class NavCat extends ValidateBase
{
    // 验证规则
    protected $rule = [
        'name'              => 'require|unique:NavCat',
    ];

    // 验证提示
    protected $message = [
        'name.require'          => '导航分类不能为空',
        'name.unique'           => '导航分类名已存在',
    ];

    // 应用场景
    protected $scene = [
        'add'  =>  ['name'],
    ];
}