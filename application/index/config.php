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

return [
     //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
    ],
    //验证码
    'captcha'  => [
            // 验证码字符集合
            'codeSet'  => '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY', 
            // 验证码字体大小(px)
            'fontSize' => 19, 
            // 是否画混淆曲线
            'useCurve' => true, 
             // 验证码图片高度
            'imageH'   => 40,
            // 验证码图片宽度
            'imageW'   => 150, 
            // 验证码位数
            'length'   => 4, 
            // 验证成功后是否重置        
            'reset'    => true
    ],
    //标签提替换
    'view_replace_str'=>[
            '__static__'=>'/static/index',
            '__ROOT__' => '/',
            '__uploads__'=>'/uploads/images'
    ]
];
