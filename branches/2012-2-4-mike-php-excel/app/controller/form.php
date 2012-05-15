<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * ����form������
 *
 *  form�������ṩ��form�����洦��ģ�顣
 */
///////////////////////////////////////////////////////////////////////////
//���ؿ���������
FLEA::loadClass('controller_base');
FLEA::loadClass('class_conditions');
FLEA::loadClass('class_using');

class controller_form extends controller_base
{
    var $_model;
    
    //���캯��
    function controller_form()
    {
	    //��ʼ��ģ��
	    $this->initView();
	    $this->checkLogin();
    }
	
    //��ʾ�޸��������
    function actionchangepwd()
    {
	    $rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		$username = isset($SE['USERNAME']) ? $SE['USERNAME'] : '';
        $this->_smarty->display('changepwd.htm');	
    }
	
	//��ʾ�ͻ�ѡ�����
    function actionFCustomer()
    {
		$using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		$cond = new class_conditions;
		$formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$cond->between($formdate,$todate,'fdate','D',2);
		
	    $dbo =& FLEA::getDBO();
		$sql = 'select fcustomercode,fcustomername from v_delivery'.$cond->getWhere().' order by fcustomercode';
		$data = $dbo->getAll($sql);
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FCustomer.htm');	
    }
	
	//��ʾ�ͻ�����ѡ�����
    function actionFCustomerType()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FCustomerType from v_salesdetail where FCustomerType<>"" and FCustomerType is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FCustomerType.htm');	
    }
	
	//��ʾƷ��ѡ�����
    function actionFBrand()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FBrand from v_salesdetail where FBrand <>"" and FBrand is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FBrand.htm');	
    }
	//��ʾ��Ʒ����ѡ�����
    function actionFType()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FType from v_salesdetail where FType <>"" and FType is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FType.htm');	
    }
	
	//��ʾ����ѡ�����
    function actionFArea()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FArea from v_salesdetail where FArea <>"" and FArea is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FArea.htm');	
    }
	
	//��ʾ����ѡ�����
    function actionFDeptName()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FDeptName from v_salesdetail where FDeptName <>"" and FDeptName is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FDeptName.htm');	
    }
	
	//��ʾҵ��Աѡ�����
    function actionFEmpIDName()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FEmpIDName from v_salesdetail where FEmpIDName <>"" and FEmpIDName is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FEmpIDName.htm');	
    }
	
	//��ʾyseno�ؼ�
    function actionyesnoselect()
    {
        $this->_smarty->display('yesno.select.htm');	
    }
	
	//��ʾ����ѡ��ؼ�
    function actionalignselect()
    {
        $this->_smarty->display('align.select.htm');	
    }
	
	//��ʾͳ��ѡ��ؼ�
    function actionsumtypeselect()
    {
        $this->_smarty->display('sumtype.select.htm');	
    }

}
