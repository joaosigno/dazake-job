<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * 定义form控制器
 *
 *  form控制器提供了form表单界面处理模块。
 */
///////////////////////////////////////////////////////////////////////////
//加载控制器基类
FLEA::loadClass('controller_base');
FLEA::loadClass('class_conditions');
FLEA::loadClass('class_using');

class controller_form extends controller_base
{
    var $_model;
    
    //构造函数
    function controller_form()
    {
	    //初始化模板
	    $this->initView();
	    $this->checkLogin();
    }
	
    //显示修改密码界面
    function actionchangepwd()
    {
	    $rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		$username = isset($SE['USERNAME']) ? $SE['USERNAME'] : '';
        $this->_smarty->display('changepwd.htm');	
    }
	
	//显示客户选择界面
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
	
	//显示客户分类选择界面
    function actionFCustomerType()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FCustomerType from v_salesdetail where FCustomerType<>"" and FCustomerType is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FCustomerType.htm');	
    }
	
	//显示品牌选择界面
    function actionFBrand()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FBrand from v_salesdetail where FBrand <>"" and FBrand is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FBrand.htm');	
    }
	//显示商品分类选择界面
    function actionFType()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FType from v_salesdetail where FType <>"" and FType is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FType.htm');	
    }
	
	//显示区域选择界面
    function actionFArea()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FArea from v_salesdetail where FArea <>"" and FArea is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FArea.htm');	
    }
	
	//显示部门选择界面
    function actionFDeptName()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FDeptName from v_salesdetail where FDeptName <>"" and FDeptName is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FDeptName.htm');	
    }
	
	//显示业务员选择界面
    function actionFEmpIDName()
    {
	    $dbo =& FLEA::getDBO();
		$data = $dbo->getAll('select distinct FEmpIDName from v_salesdetail where FEmpIDName <>"" and FEmpIDName is not null');
		$this->_smarty->assign('data',$data);
        $this->_smarty->display('FEmpIDName.htm');	
    }
	
	//显示yseno控件
    function actionyesnoselect()
    {
        $this->_smarty->display('yesno.select.htm');	
    }
	
	//显示对齐选择控件
    function actionalignselect()
    {
        $this->_smarty->display('align.select.htm');	
    }
	
	//显示统计选择控件
    function actionsumtypeselect()
    {
        $this->_smarty->display('sumtype.select.htm');	
    }

}
