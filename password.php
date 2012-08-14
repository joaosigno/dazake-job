<?php
	$websize = $_POST['sendData1'];
	$config = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	$keyword = $_POST['sendData2'];
	$new_websize = '';
	$ans_password = '';
	
	//处理成因子位数
	for($i=0; $i<count($keyword); $i++){
		if(strlen($websize)>$i)
			$key_num = $i;
		else
			$key_num = $i%strlen($websize);
		
		$new_websize[$i] = $websize[$key_num];
		$key = (array_search($new_websize[$i],$config)+$keyword[$i])%count($config);
		
		$ans_password[$i] = $config[$key];
		
	}
	
	echo '1989@';
	
	
	foreach($ans_password as $item){
		echo $item;
	}
	
	// echo chr(ord('a')+4);
	
	
	
	



?>