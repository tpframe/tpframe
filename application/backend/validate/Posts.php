<?php
namespace app\backend\validate;

/**
 * 文章验证器
 */
class Posts extends AdminBase
{
    // 验证规则
    protected $rule = [
        'title'              => 'require',
    ];

    // 验证提示
    protected $message = [
        'title.require'          => '文章名称不能为空',
    ];

    // 应用场景
    protected $scene = [
        'add'  =>  ['title'],
    ];
}