<?php

//»ñÈ¡ÊÚÈ¨url

function qq_login_url($appid, $scope, $callback)

{

    $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection

    $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 

        . $appid . "&redirect_uri=" . urlencode($callback)

        . "&state=" . $_SESSION['state']

        . "&scope=".$scope;

	return $login_url;

}





function getImg($url = "", $filename = "") { 

		if(is_dir(basename($filename))) { 

			echo "The Dir was not exits"; 

			Return false; 

		}

		$url = preg_replace( '/(?:^[\'"]+|[\'"\/]+$)/', '', $url ); 

		$hander = curl_init(); 

		$fp = fopen($filename,'wb'); 

		curl_setopt($hander,CURLOPT_URL,$url); 

		curl_setopt($hander,CURLOPT_FILE,$fp); 

		curl_setopt($hander,CURLOPT_HEADER,0); 

		curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1); 

		curl_setopt($hander,CURLOPT_TIMEOUT,60); 

		curl_exec($hander); 

		curl_close($hander); 

		fclose($fp); 

		Return true; 

	} 