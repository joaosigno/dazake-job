<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * ����jsreport ���㱨�������
 *
 */
///////////////////////////////////////////////////////////////////////////
//���ؿ���������
FLEA::loadClass('controller_base');
FLEA::loadClass('class_using');
FLEA::loadClass('class_excel');
FLEA::loadClass('class_conditions');
FLEA::loadClass('class_order');

class controller_jsreport extends controller_base
{
	var $sql;
	
    //���캯��
    function controller_jsreport()
    {
	    //��ʼ��ģ��
	    $this->initView();
	    $this->checkLogin();
    }
	
    //���㱨�������ҳ
    function actionindex()
    {
	  
    }
	
	//���㱨��
	function actionReceivables()
    {

    }


}
