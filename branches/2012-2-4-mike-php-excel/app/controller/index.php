<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * ����Index������
 *
 */
////////////////////////////////////////////////////////////////////////////
//���ؿ���������
FLEA::loadClass('controller_base');

class controller_index extends controller_base
{  
	var $_model;
    var $_title;
	
    //���캯��
    function controller_index()
    {
     	//��ʼ��ģ��
	    $this->initView();
	    $this->checkLogin();
    }
	
    //��ҳ
    function actionindex()
    {	
		//���ñ���
		$this->_title = '������ҳ';
			
		$rbac =& FLEA::getSingleton('FLEA_Rbac');
        $user = $rbac->getUser();
		//ģ�帳ֵ
		$this->_model =& FLEA::getSingleton('model_user');
        $_user = $this->_model->find($user['UID']);
		if(isset($_user))
		{
			$this->_smarty->assign('RepAct',explode(',',$_user['RepAct']));
			$this->_smarty->assign('title',$this->_title);
            $this->_smarty->display('main.htm');	 
		}
    }
}
