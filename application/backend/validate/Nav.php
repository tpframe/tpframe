<?php
namespace app\backend\validate;

class Nav extends AdminBase
{
    // 验证规则
    protected $rule = [
        'label'              => 'require',
        'href'              => 'require'
    ];

    // 验证提示
    protected $message = [
        'label.require'          => '标签不能为空',
        'href.require'          => '链接地址不能为空'
    ];

    // 应用场景
    protected $scene = [
        'add'  =>  ['label','href'],
    ];
}