<?php
//ʹ��fleaphp1.0.7�汾��������
//��ʾ�������� FleaPHP 1.0.6x ���ּ��ݵ��ļ�,��� NO_LEGACY_FLEAPHP Ϊ true ʱ�����Ӧ�ó����޷�ִ�У���˵����ʹ����һЩ FleaPHP 1.0.6x �ĺ������á�
define('NO_LEGACY_FLEAPHP',true);

//����ʱ��
date_default_timezone_set('Asia/Shanghai');

//����ͨ����·��
define("COMM_DIR",   str_replace("\\","/",dirname(__FILE__)."/comm"));

//���������ļ�·��
define("CONF_DIR",   str_replace("\\","/",dirname(__FILE__)."/config"));

//������Ŀ·��·��
define("PROJECT_DIR",str_replace("\\","/",dirname(__FILE__)));

//����Ӧ�ó����Ŀ¼
define("APP_DIR",    str_replace("\\","/",dirname(__FILE__)."/app"));

//����FLEA�����ں���
require(COMM_DIR.'/FLEA/FLEA.php');

//���������ļ�
FLEA::loadAppInf(CONF_DIR.'/app.php');
FLEA::loadAppInf(CONF_DIR.'/db.php');
FLEA::loadAppInf(CONF_DIR.'/smarty.php');
//���ó������·��
FLEA::import(APP_DIR);

//__TRY();

FLEA::runMVC();

////$ex = __CATCH();

//if (__IS_EXCEPTION($ex))
//{
  //  dump($ex);
//}
?>