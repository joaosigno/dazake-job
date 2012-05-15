<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * ����Login������
 *  Login �������ṩ�˹���Ա�û���½��ע����½���û�ע��ȹ��ܡ�
 */
////////////////////////////////////////////////////////////////////////////
//���ؿ���������
FLEA::loadClass('controller_base');
FLEA::loadClass('class_validator');
 
class controller_Login extends controller_base
{
    var $_model;
    var $_title;
    var $_smarty;
	
    //���캯��
    function controller_login()
    {   
        //��ʼ��ģ��
        $this->initView();
    }
	
	//��̨�û���½ҳ
    function actionindex()
    {		
        $this->_smarty->display('login.htm');
    }	
	
	//��̨�û���½����
    function actionlogin()
    {		
	    if (!isset($_POST['Username']))
        {
		    js_alert('�û�������Ϊ�գ�','history.back()'); 
		};
		if (!isset($_POST['password']))
        {
		    js_alert('���벻��Ϊ�գ�','history.back()'); 
		};
		if (!isset($_POST['chkcode']))
        {
		    js_alert('��֤�벻��Ϊ�գ�','history.back()'); 
		};
		$validator = new class_validator;
        $sysuser =& FLEA::getSingleton('model_sysuser');
	    $imgcode =& FLEA::getSingleton('FLEA_Helper_ImgCode');
		
		//�����û��������û�
        $user = $sysuser->findByUserName($_POST['Username']);
		
		//�ж��û��Ƿ����
		if (!$user) 
	    {
            js_alert('�û�δע�ᣡ','history.back()'); 
		}
		//�������
		elseif (!$sysuser->checkPassword($_POST['password'],$user[$sysuser->passwordField]))
        {
            js_alert('�������','history.back()'); 
        }
		elseif (!$imgcode->check($_POST['chkcode']))
        {
            js_alert('��֤�����','history.back()'); 
        }           
		else
		{
		
		    //��¼�ɹ���ͨ�� RBAC �����û���Ϣ�ͽ�ɫ
            $data = array();
			$data['UID']      = $user[$sysuser->primaryKey];
            $data['USERNAME'] = $user[$sysuser->usernameField];
			$data['EMAIL']    = $user[$sysuser->emailField];
			$data['TIME']     = date('Y-m-d H:i:s');
			$data['IsSuperUser'] = $user['IsSuperUser'];
            $rbac =& FLEA::getSingleton('FLEA_Rbac');
            $rbac->setUser($data, $sysuser->fetchRoles($user));
            // �������ҳ
           redirect(url('index',''));
			//dump($_SESSION);  
			//dump($user);
		}
		$imgcode->clear();
		
    }	
	
	// �û�ע��
    function actionlogout()
	{
        session_destroy();
        js_alert('�˳��ɹ���','history.back()');
    }
	
	// �û�ע��
    function actionsignup()
	{
        session_destroy();
        $this->_smarty->display('signup.htm');
    }
	
    //��ȡ��֤��
    function actionimgCode() 
	{
	    /* FLEA_Helper_ImgCode */
        $imgcode =& FLEA::getSingleton('FLEA_Helper_ImgCode');
        $imgcode->image();
    }
 
}
