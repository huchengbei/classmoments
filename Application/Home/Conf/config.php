<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'classmoments', // 数据库名
    'DB_USER'   => 'classmoments', // 用户名
    'DB_PWD'    => 'classmoments', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => 'class_', // 数据库表前缀
	SESSION_OPTIONS => array(
		'expire' => 3600 //session保存30分钟
	)
);