<?php
$ch = curl_init();
$params = array(
	'api_key' => '66bab534984c43b0bf8013ed66ef8e35',
	'method' => 'photos.upload',
	'v' => '1.0',
	'call_id' => time(),
	'session_key' => '6.cf4709e7ea425c66bfcc25a02bf82e64.2592000.1325174400-363524545',
	'format' => 'json',
	'caption' => 'This is the caption.'
);
//����sig
$params['sig'] = rr_generate_sig($params, 'cf7c0115182448c2ac10d1a1951a3e53');
//����sigʱ��Ҫ��Ҫ�ϴ����ļ��������ڡ����Էŵ�sig�����������
// $params['upload'] = '@C:\\tem.jpg';

$params['upload'] = '@D:\wamp\www\xampp\my-renren\upload\Apple14.jpg';
curl_setopt($ch, CURLOPT_URL, "http://api.renren.com/restserver.do");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
$result = curl_exec($ch);

print_r(json_decode($result));


function rr_generate_sig($params, $secret) {
	ksort($params);
	$sig = '';
	foreach($params as $key=>$value) {
		$sig .= "$key=$value";
	}
	$sig .= $secret;
	return md5($sig);
}
?>