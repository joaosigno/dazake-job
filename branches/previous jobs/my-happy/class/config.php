<?php
	define( "WEB_SIZE" , 'http://localhost/xampp/my-happy/' ); //网站路径
	define( "MESSAGE_COUNT" , 5 ); //每页显示数据数
	define( "EXPIRES_IN" , 2500000 ); //expires_in过期时间少于一个月
	define( "DF_CALLBACK" , 'http://localhost/xampp/my-happy/class/redirect.php' ); //回调地址，注意和您申请的应用一致
	define( "DF_APIKEY" , '6450844693976b11a4ea35b367b76f45' ); //你的API Key，请自行申请
	define( "DF_SECRETKEY" , 'fe12d345e4c5328fcc2778b70b0b2889' ); //你的API 密钥
	define( "DB_TABLE_PREFIX" , 'wfw_' ); //数据表前缀
	define( "WEB_TEST" , TRUE ); //是否开启测试用户。移动到服务器后，如果能读出$_SESSION['id']，请设置为假。
