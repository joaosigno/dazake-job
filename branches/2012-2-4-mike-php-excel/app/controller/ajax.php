<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * ����ajax������
 *
 *  ajax�������ṩ��ajax����ģ�顣
 */
///////////////////////////////////////////////////////////////////////////
//���ؿ���������
FLEA::loadClass('controller_base');

class controller_ajax extends controller_base
{
    var $_model;
    
    //���캯��
    function controller_ajax()
    {
	    $this->initView();
	    $this->checkLogin();
    }
    //
    function actionchangepwd()
    {
	    $rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
	  	if(!$SE)
		{
		    $this->writeAjax('300','����Ȩִ�д˲���!','','','');
        };
	    //�����Ϣ�Ƿ�Ϊ��
		if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword']))
		{
		    $this->writeAjax('300','�ύ��Ϣ������!','','','');
		}
		else
		{
		    $sysuser =& FLEA::getSingleton('model_sysuser');
			if ($sysuser -> changePassword($SE['USERNAME'],$_POST['oldPassword'],$_POST['newPassword']))
			{
			   $this->writeAjax('200','�޸ĳɹ�!', 'navNewsLi','closeCurrent','');
			}
			else
			{
			   $this->writeAjax('300','�������������!','','','');
			} 
		}
    }
	
	//
    function actionuseredit()
    {
	    $this->writeAjax('200','����ɹ�!','','','');
    }
	
	
	
}
