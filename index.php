<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
// 运行时目录
define('RUNTIME_PATH', __DIR__ . '/data/runtime/');
// 扩展包目录
define('VENDOR_PATH', __DIR__  . '/coreframe/vendor/');
// 加载框架引导文件
require __DIR__ . '/coreframe/thinkphp/start.php';
