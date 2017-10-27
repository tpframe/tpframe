<?php
//配置文件
return [
    /* 模板常量替换配置 */
    'view_replace_str' => [
        '__THEMES__' =>  '/theme/frontend/'.FRONTEND_THEME.'/assets',
        '__DATA__' => SITE_PATH.'/data/',
        // 上传文件路径
        '__UPLOAD__' =>SITE_PATH.'/data/'.'uploads/',
    ],
    
    /* 模板布局配置 */
    'template'  =>  [
        'view_path'     =>  './theme/frontend/'.FRONTEND_THEME.'/',     //设置模板位置
        'layout_on'     =>  true,
        'layout_name'   =>  'layout',
        'tpl_cache'     =>  false,
        // 预加载自定义模板标签
        'taglib_pre_load'     =>    'tpfcore\taglib\Tpf',
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
];
