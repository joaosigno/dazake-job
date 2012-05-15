<?php

	//获取用户好友
	$friends = $client->POST('friends.getFriends',array($_GET['page'],MESSAGE_COUNT));
?>




















