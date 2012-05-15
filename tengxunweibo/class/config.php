<?php
$con_arr = array();	
$con_arr[55] = '「眼波传情型」55% 感情丰富的你会有意无意地透过眼神放电，不自觉地让别人暗恋你。[呵呵]还真是。看看#你被人暗恋的指数有多高#http://apps.weibo.com/playbal 分享自@翻到就行';
$con_arr[20] = '你活在自己世界中，反应永远慢半拍，就算别人对你示好，你反而还感应不到。[呵呵]还真是。看看#你被人暗恋的指数有多高';
$con_arr[99] = '「狮子示爱型」99% 你会不自觉地经由身体的接触，让别人觉得你对他有意思，相对地也使别人对你献殷勤的机会大增。[呵呵]还真是。看看#你被人暗恋的指数有多高#http://apps.weibo.com/playbal 分享自@翻到就行';
$con_arr[40] = '「无聊解闷型」40% 当生活乏味无聊时，你会偶尔放放电，让人家觉得平常不太出色的你还满吸引人的。[呵呵]还真是。看看#你被人暗恋的指数有多高#http://apps.weibo.com/playbal 分享自@翻到就行';
$con_arr[80] = '「对话传情型」80% 感性的你容易在言语中向别人挑逗暗示，让人觉得你好像在告诉对方可以接近。[呵呵]还真是。看看#你被人暗恋的指数有多高#http://apps.weibo.com/playbal 分享自@翻到就行';


//获取ip函数
function getIP() { 
if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) 
$ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
else if (@$_SERVER["HTTP_CLIENT_IP"]) 
$ip = $_SERVER["HTTP_CLIENT_IP"]; 
else if (@$_SERVER["REMOTE_ADDR"]) 
$ip = $_SERVER["REMOTE_ADDR"]; 
else if (@getenv("HTTP_X_FORWARDED_FOR"))
$ip = getenv("HTTP_X_FORWARDED_FOR"); 
else if (@getenv("HTTP_CLIENT_IP")) 
$ip = getenv("HTTP_CLIENT_IP"); 
else if (@getenv("REMOTE_ADDR")) 
$ip = getenv("REMOTE_ADDR"); 
else 
$ip = "Unknown"; 
return $ip; 
}
?>