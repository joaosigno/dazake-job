<?php
//使用fleaphp1.0.7版本开发环境
//表示不载入与 FleaPHP 1.0.6x 保持兼容的文件,如果 NO_LEGACY_FLEAPHP 为 true 时，你的应用程序无法执行，那说明你使用了一些 FleaPHP 1.0.6x 的函数调用。
define('NO_LEGACY_FLEAPHP',true);

//设置时区
date_default_timezone_set('Asia/Shanghai');

//定义通用类路径
define("COMM_DIR",   str_replace("\\","/",dirname(__FILE__)."/comm"));

//定义配置文件路径
define("CONF_DIR",   str_replace("\\","/",dirname(__FILE__)."/config"));

//定义项目路径路径
define("PROJECT_DIR",str_replace("\\","/",dirname(__FILE__)));

//定义应用程序的目录
define("APP_DIR",    str_replace("\\","/",dirname(__FILE__)."/app"));

//加载FLEA框架入口函数
require(COMM_DIR.'/FLEA/FLEA.php');

//加载配置文件
FLEA::loadAppInf(CONF_DIR.'/app.php');
FLEA::loadAppInf(CONF_DIR.'/db.php');
FLEA::loadAppInf(CONF_DIR.'/smarty.php');
//设置程序加载路径
FLEA::import(APP_DIR);

//__TRY();

FLEA::runMVC();

////$ex = __CATCH();

//if (__IS_EXCEPTION($ex))
//{
  //  dump($ex);
//}
?>