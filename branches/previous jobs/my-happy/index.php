<?php
/**
*û��$_SESSION['id']ֱ����ת����½ҳ��
*��Ȩ��Ч��д��session�������û���ҳ
*��Ȩ��Ч�����refresh_token����Ч����refresh_tokenˢ����Ȩ
*refresh_tokenҲ���ڡ�ֻ�ܵ�������������Ȩ
*/
?>
<?php
session_start();
require_once('./class/requires.php');

//��������$_SESSION['id']����Ϊ1�����ڷ���������$_SESSION['id']ɾ����δ��롣������config.php�ļ�����WEB_TESTΪ��
if(WEB_TEST){
	$_SESSION['id'] = 1;
}

//û$_SESSION['id'] ֱ�ӻص���½����
if(!isset($_SESSION['id'])){
	header("Location: ./modular/login.php");
}

//����$_SESSION['id']�����û���Ϣ
$db = new DB();
$sql = "SELECT * FROM ".DB_TABLE_PREFIX."happy_user WHERE `w_id` = {$_SESSION['id']} LIMIT 0,1";
$result = $db->get_one($sql);


	if($result && (time()-$result['token_insert_time']<EXPIRES_IN)&&!empty($result['access_token'])){
		/***�ض��򵽿�����ҳ***/
		$_SESSION['happy_access_token'] = $result['access_token'];
		header("Location: ./home.php");
		
		
	}elseif($result && (time()-$result['token_insert_time']<EXPIRES_IN*2)&&!empty($result['refresh_token'])){
		/***�ض���refresh_tokenˢ��token***/
		header("Location: ./class/refresh_token.php");
	}else{
		/***����2����û��½��Ҫ��������������Ȩ***/
		header("Location: ./class/authorize.php");
		// echo '�ܾ�û�е�¼';
	}
?>


