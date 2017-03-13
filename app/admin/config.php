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
	//模板参数替换
	'view_replace_str' => [
			'__CSS__'			=> 	'http://'.$_SERVER['SERVER_NAME'].'/Thinkphp5.0.5/public/admin/css',
			'__JS__'			=> 	'http://'.$_SERVER['SERVER_NAME'].'/Thinkphp5.0.5/public/admin/js',
			'__FONTS__'	=> 	'http://'.$_SERVER['SERVER_NAME'].'/Thinkphp5.0.5/public/admin/fonts',
			'__IMG__'			=> 	'http://'.$_SERVER['SERVER_NAME'].'/Thinkphp5.0.5/public/admin/images',
			'__STATIC__' 	=> 	'http://'.$_SERVER['SERVER_NAME'].'/Thinkphp5.0.5/public/static'
	],

];
