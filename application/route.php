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
// $Id$
use think\Route;
// 全局参数设置
Route::pattern([
    'name' => '\w+',
    'id'   => '\d+',
    'all'  => '.*',
]);
Route::get('blog/:name','index/a.index/:name');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    
    // 'hello/[:name]'=>['index/index/index',['method'=>'get','ext'=>'html']],
    // 'log_kjh/scxz/[:id]'=>['index/a.index/index',['method'=>'get','ext'=>'html','id'=>'\d+']],
    // 'log_kjh/scxz'=>['index/a.index/index',['method'=>'get','ext'=>'html']]
];
