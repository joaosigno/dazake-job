<?php
define( "WB_AKEY" , '1011401711' );//api key
define( "WB_SKEY" , 'ddf0738f966414e44a2ceb45d2a9b80c' );//api 密钥
define( "WB_CALLBACK_URL" , 'http://localhost/xampp/my-weibo/callback.php' );//回调函数
define( "WEB_SIZE" , 'http://localhost/xampp/my-weibo/' ); //网站路径，不要漏了最后一斜杠 ‘/’
define( "MY_COUNT" , 5 );//每页显示数据数
define( "EXPIRES_IN" , 7200 ); //expires_in  token过期时间
define( "DB_TABLE_PREFIX" , 'wfw_' ); //数据表前缀
define( "WEB_TEST" , TRUE ); //是否开启测试用户。移动到服务器后，如果能读出$_SESSION['id']，请设置为假。
