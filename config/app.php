<?php
/** 应用程序配置 */
return array
(
     //设置日志类型
    'logErrorLevel'=> 'notice,debug,warning,error,exception,log',

    //是否开启日志记录
    'logEnabled'=> false,

    //设置缓存目录
    'internalCacheDir' => PROJECT_DIR . '/_cache',

    //应用程序标题
    'appTitle'=> '',

    //应用程序网址
    'appDomain'=>'http://'.$_SERVER['HTTP_HOST'].'/',

    //指定默认控制器
    'defaultController'=>'index',

    //启用多语言支持
    'multiLanguageSupport'=>true,
	
	'defaultLanguage'  =>'chinese-gb2312',

    // 指定要使用的调度器
    'dispatcher'=>'FLEA_Dispatcher_Auth',

    //使用默认的控制器 ACT 文件
    'defaultControllerACTFile' => CONF_DIR.'/act.php',
	
    // 必须设置该选项为 true，才能启用默认的控制器 ACT 文件
    'autoQueryDefaultACTFile' => true,
	
	//指示 FleaPHP 应用程序内部处理数据和输出内容要使用的编码
	'responseCharset'=>'gb2312',

    // 当 FleaPHP 连接数据库时，用什么编码传递数据
    'databaseCharset'=>'gb2312',

    //指示在 session 中用什么名字保存用户的信息
    'RBACSessionKey' =>'USER'
);
?>
