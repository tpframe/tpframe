<?php
//配置文件
return [
    /* 模板常量替换配置 */
    'view_replace_str' => [
        '__THEMES__' =>  '/theme/backend/assets',
    ],
    
    /* 模板布局配置 */
    'template'  =>  [
        'view_path'     =>  './theme/backend/',     //设置模板位置
        'layout_on'     =>  false,
        'layout_name'   =>  'layout'
    ],
    
    //验证码
    'captcha'  => [
        // 验证码字符集合
        'codeSet'  => '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY', 
        // 验证码字体大小(px)
        'fontSize' => 35, 
        // 是否画混淆曲线
        'useCurve' => true, 
         // 验证码图片高度
        'imageH'   => 80,
        // 验证码图片宽度
        'imageW'   => 320, 
        // 验证码位数
        'length'   => 5, 
        // 验证成功后是否重置        
        'reset'    => true
    ],
    //插件分类
    'addon_class'=>[
        0=>[
            'type'=>"module",
            "name"=>"模块插件"
        ],
        1=>[
            'type'=>"behavior",
            "name"=>"行为插件"
        ],
        2=>[
            'type'=>"behavior_module",
            "name"=>"行为模块插件"
        ]
    ]
];
