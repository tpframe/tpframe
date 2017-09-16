<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\common\validate;

/**
 * 基础验证器
 */
class Links extends ValidateBase
{
	// 验证规则
    protected $rule = [
        'name'              => 'require|unique:links',
    ];

    // 验证提示
    protected $message = [
        'name.require'          => '友情链接不能为空',
        'name.unique'     => '友情链接已存在',
    ];

    // 应用场景
    protected $scene = [
        'add'  =>  ['name'],
    ];
}
