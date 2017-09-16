<?php
namespace app\common\validate;

/**
 * 基础验证器
 */
class SlideCat extends ValidateBase
{
    // 验证规则
    protected $rule = [
        'cat_name'              => 'require',
        'cat_idname'              => 'alphaDash',
    ];

    // 验证提示
    protected $message = [
        'cat_name.require'          => '分类名称不能为空',
        'cat_idname.alphaDash'     => '分类标识必须是英文字母,数字或下划线(“_”)',
    ];

    // 应用场景
    protected $scene = [
        'add'  =>  ['cat_name','cat_idname'],
    ];
}