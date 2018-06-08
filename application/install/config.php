<?php
//配置文件
return [
    /* 模板常量替换配置 */
    'view_replace_str' => [
        '__THEMES__' =>  DS.'theme'.DS.'install'.DS.'assets',
        '__DATA__' => SITE_PATH.DS.'data'.DS,
        // 上传文件路径
        '__UPLOAD__' =>SITE_PATH.DS.'data'.DS.'upload'.DS,
    ],
    
    /* 模板布局配置 */
    'template'  =>  [
        'view_path'     =>  '.'.DS.'theme'.DS.'install'.DS,     //设置模板位置
        'tpl_cache'     =>  false
    ],
    'TPFRAME_VERSION' => "TPFrame v2.1.0316",
];
