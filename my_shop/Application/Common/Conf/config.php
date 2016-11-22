<?php
return array(
	//'配置项'=>'配置值'
    // 添加数据库配置信息
    'DB_TYPE'=>'mysql',// 数据库类型
    'DB_HOST'=>'localhost',// 服务器地址
    'DB_NAME'=>'shop',// 数据库名
    'DB_USER'=>'root',// 用户名
    'DB_PWD'=>'',// 密码
    'DB_PORT'=>3306,// 端口
    'DB_PREFIX'=>'x_',// 数据库表前缀
    'DB_CHARSET'=>'utf8',// 数据库字符集


    //七牛atart
    'UPLOAD_SITEIMG_QINIU' => array (
        'maxSize' => 5 * 1024 * 1024,//文件大小
        'rootPath' => './',
        'saveName' => array ('uniqid', ''),
        'driver' => 'Qiniu',
        'driverConfig' => array (
        'secrectKey' => 'oL1R7rDw8lxUjSrYRveK7ne5ZRSJ3kYBXvL8QiEz',
        'accessKey' => 's93DygHPJBdlY-ytZV8J32HcTWq-CNv59Mzw-4yu',
        'domain' => 'img.birandz.com',
        'bucket' => 'biran',
        )),
    //七牛end

    'SHOW_PAGE_TRACE' => 0,

);
