<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use \think\Request;
$pathinfo=strtolower(Request::instance()->pathinfo());
$pathinfo=$pathinfo=='backend'?$pathinfo.'/':$pathinfo;
if(!preg_match('/^backend\//',$pathinfo) && !preg_match('/^frontend\//',$pathinfo) && !preg_match('/^api/',$pathinfo) && file_exists("data/install.lock")){
    \think\Route::bind('frontend');
};
return [
    '__pattern__' => [
        'name' => '\w+',
    ],

    'robot'=>'addon/execute?c=robot&a=index&m=application',
    
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
];
