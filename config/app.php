<?php
/** Ӧ�ó������� */
return array
(
     //������־����
    'logErrorLevel'=> 'notice,debug,warning,error,exception,log',

    //�Ƿ�����־��¼
    'logEnabled'=> false,

    //���û���Ŀ¼
    'internalCacheDir' => PROJECT_DIR . '/_cache',

    //Ӧ�ó������
    'appTitle'=> '',

    //Ӧ�ó�����ַ
    'appDomain'=>'http://'.$_SERVER['HTTP_HOST'].'/',

    //ָ��Ĭ�Ͽ�����
    'defaultController'=>'index',

    //���ö�����֧��
    'multiLanguageSupport'=>true,
	
	'defaultLanguage'  =>'chinese-gb2312',

    // ָ��Ҫʹ�õĵ�����
    'dispatcher'=>'FLEA_Dispatcher_Auth',

    //ʹ��Ĭ�ϵĿ����� ACT �ļ�
    'defaultControllerACTFile' => CONF_DIR.'/act.php',
	
    // �������ø�ѡ��Ϊ true����������Ĭ�ϵĿ����� ACT �ļ�
    'autoQueryDefaultACTFile' => true,
	
	//ָʾ FleaPHP Ӧ�ó����ڲ��������ݺ��������Ҫʹ�õı���
	'responseCharset'=>'gb2312',

    // �� FleaPHP �������ݿ�ʱ����ʲô���봫������
    'databaseCharset'=>'gb2312',

    //ָʾ�� session ����ʲô���ֱ����û�����Ϣ
    'RBACSessionKey' =>'USER'
);
?>
