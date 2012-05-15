<?php

/* load library. */
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'requires.php');


/* Build KXOAuth object with client credentials. */
$connection = new KXClient();
$scope = 'create_records create_album user_photo friends_photo friends_records friends_diary friends_repaste upload_photo user_records';
$url = $connection->getAuthorizeURL('code',$scope);
header("Location: $url");
?>


