<?php
	session_start();	
	$dir = dirname(__FILE__);
	$dir = str_replace('modular','class',$dir);
	
	include_once($dir.DIRECTORY_SEPARATOR.'upload.class.php');
	include_once($dir.DIRECTORY_SEPARATOR.'requires.php');	
	$upload = new upload();
	$upload->upload_file();
	$ch = curl_init();
	if(!isset($_POST['replaceCaption']))
		$_POST['replaceCaption'] = '上传一张图片';
	$params = array(
		'api_key' => DF_APIKEY,
		'method' => 'photos.upload',
		'v' => '1.0',
		'call_id' => time(),
		'session_key' => $_SESSION['key']['renren_token']['session_key'],
		'format' => 'json',
		'caption' => $_POST['replaceCaption'],
	);
//计算sig
$params['sig'] = rr_generate_sig($params, DF_SECRETKEY);
//计算sig时不要把要上传的文件包括在内。所以放到sig后面加入数组
	$dir = dirname(__FILE__);
	$dir = str_replace('modular','upload',$dir);
$params['upload'] = '@'.$dir.DIRECTORY_SEPARATOR.$upload->upload_final_name;
// $params['upload'] = '@'.$_FILES['file']['tmp_name'];
curl_setopt($ch, CURLOPT_URL, "http://api.renren.com/restserver.do");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//以文件流返回
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
$result = json_decode(curl_exec($ch),true);
//数据入库
	if($result){
		include_once('../class/db.class.php');
		$db = new DB();
		$sql_arr = array();
		$sql_arr['w_id'] = $_SESSION['id'];
		$sql_arr['type'] = 'photo';
		$sql_arr['prefix'] = $result['caption'];			
		$sql_arr['messages'] = $result['caption'];		
		$sql_arr['img'] = $result['src_big'];		
		$sql_arr['addTime'] = time();			
		$db->insert(DB_TABLE_PREFIX.'renren_message',$sql_arr);
	}

//删除文件
	if($result&&file_exists($dir.DIRECTORY_SEPARATOR.$upload->upload_final_name)){
	   unlink($dir.DIRECTORY_SEPARATOR.$upload->upload_final_name);
	}

echo $result['src_big'];
// print_r($result);
	
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