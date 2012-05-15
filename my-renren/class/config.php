<?php
	define( "WEB_SIZE" , 'http://localhost/xampp/my-renren/' ); //网站路径
	define( "MESSAGE_COUNT" , 5 ); //每页显示数据数
	define( "EXPIRES_IN" , 2500000 ); //expires_in过期时间少于一个月
	define( "DF_CALLBACK" , 'http://localhost/xampp/my-renren/class/callback.php' ); //回调地址，注意和您申请的应用一致
	define( "DF_APIKEY" , '66bab534984c43b0bf8013ed66ef8e35' ); //你的API Key，请自行申请
	define( "DF_SECRETKEY" , 'cf7c0115182448c2ac10d1a1951a3e53' ); //你的API 密钥
	define( "DB_TABLE_PREFIX" , 'wfw_' ); //数据表前缀
	define( "WEB_TEST" , TRUE ); //是否开启测试用户。移动到服务器后，如果能读出$_SESSION['id']，请设置为假。
