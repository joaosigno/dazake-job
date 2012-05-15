<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * ����report������
 *
 */
///////////////////////////////////////////////////////////////////////////
//���ؿ���������
FLEA::loadClass('controller_base');
FLEA::loadClass('class_using');
FLEA::loadClass('class_excel');
FLEA::loadClass('class_conditions');
FLEA::loadClass('class_order');

class controller_salesreport extends controller_base
{
	var $sql;
	
    //���캯��
    function controller_salesreport()
    {
	    //��ʼ��ģ��
	    $this->initView();
	    $this->checkLogin();
    }
	
    //���������ҳ
    function actionindex()
    {
	  
    }
	
	//������ϸ��
    function actionrepsale()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
		$this->sql  = 'select * from v_salesdetail';
		
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$cond->between($formdate,$todate,'fdate','D',2);
		
		//����
		$order = new class_order($request);
		
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
	    
		
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);

		$allFProfit =$this->_count($alldata,'FProfit');
		$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
		$data = array_slice($alldata, $page['offset'], $page['size'] , true);
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
		   $this->_smarty->assign('allFProfit',$allFProfit);
		   $this->_smarty->assign('allFSaleAmount',$allFSaleAmount);
	       $this->_smarty->display('repsale.htm');
	    }
		
    }
	
	//������ϸ��-���ͻ�����
    function actionrepsaleFCustomerType()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FCustomerType,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
		//��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FCustomerType = isset($request['FCustomerType_name']) ? trim($this->u2gbk($request['FCustomerType_name'])) : null;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FCustomerType,'FCustomerType','S',' and ');
		
		//����
		$order = new class_order($request);
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FCustomerType '.$order->getOrder());
		
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);
		
		$allFProfit =$this->_count($alldata,'FProfit');
		$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
	    $data = array_slice($alldata, $page['offset'], $page['size'] , true);
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('FCustomerType'  ,$FCustomerType);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
		   $this->_smarty->assign('allFProfit',$allFProfit);
		   $this->_smarty->assign('allFSaleAmount',$allFSaleAmount);
	       $this->_smarty->display('repsale.FCustomerType.htm');
	    }
    }
	
	//������ϸ��-������Ʒ��
    function actionrepsaleFBrand()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FBrand,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate'])    ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])      ? $request['todate']   : date("Y-m-d");
		$FBrand   = isset($request['FBrand_name']) ? trim($this->u2gbk($request['FBrand_name'])) : null;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FBrand,'FBrand','S',' and ');
		
		//����
		$order = new class_order($request);
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FBrand '.$order->getOrder());
		
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);
		
		$allFProfit =$this->_count($alldata,'FProfit');
		$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
		$data = array_slice($alldata, $page['offset'], $page['size'] , true);
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('FBrand'  ,$FBrand);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
		   $this->_smarty->assign('allFProfit',$allFProfit);
		   $this->_smarty->assign('allFSaleAmount',$allFSaleAmount);
	       $this->_smarty->display('repsale.FBrand.htm');
	    }
    }
	
	//������ϸ��-����Ʒ����
	function actionrepsaleFType()
    {
		//�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FType,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FType = isset($request['FType_name']) ? trim($this->u2gbk($request['FType_name'])) : null;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FType,'FType','S',' and ');
		
		//����
		$order = new class_order($request);
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FType '.$order->getOrder());
		
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);
		
		$allFProfit =$this->_count($alldata,'FProfit');
		$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
		$data = array_slice($alldata, $page['offset'], $page['size'] , true);
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('FType'  ,$FType);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
		   $this->_smarty->assign('allFProfit',$allFProfit);
		   $this->_smarty->assign('allFSaleAmount',$allFSaleAmount);
	       $this->_smarty->display('repsale.FType.htm');
	    }
    }
	
	//������ϸ��-������
	function actionrepsaleFArea()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
		$this->sql = 'select FArea,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FArea = isset($request['FArea_name']) ? trim($this->u2gbk($request['FArea_name'])) : null;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FArea,'FArea','S',' and ');
		
		//����
		$order = new class_order($request);
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FArea '.$order->getOrder());
		
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);
		
		$allFProfit =$this->_count($alldata,'FProfit');
		$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
		$data = array_slice($alldata, $page['offset'], $page['size'] , true);
	
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('FArea'  ,$FArea);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
		   $this->_smarty->assign('allFProfit',$allFProfit);
		   $this->_smarty->assign('allFSaleAmount',$allFSaleAmount);
	       $this->_smarty->display('repsale.FArea.htm');
	    }
    }
	
	//������ϸ��-������
	function actionrepsaleFDeptName()
    {
	   		//�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FDeptName,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FDeptName = isset($request['FDeptName_name']) ? trim($this->u2gbk($request['FDeptName_name'])) : null;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FDeptName,'FDeptName','S',' and ');
		
		//����
		$order = new class_order($request);
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FDeptName '.$order->getOrder());
		
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);
		
		$allFProfit =$this->_count($alldata,'FProfit');
		$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];		
    	$data = array_slice($alldata, $page['offset'], $page['size'] , true);
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('FDeptName'  ,$FDeptName);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
		   $this->_smarty->assign('allFProfit',$allFProfit);
		   $this->_smarty->assign('allFSaleAmount',$allFSaleAmount);
	       $this->_smarty->display('repsale.FDeptName.htm');
	    }
    }
	
	//������ϸ��-��ҵ��Ա
	function actionrepsaleFEmpIDName()
    {
        //�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');

		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FEmpIDName,FSaleStyleName,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FEmpIDName = isset($request['FEmpIDName_name']) ? trim($this->u2gbk($request['FEmpIDName_name'])) : null;
		$FSaleStyleName = isset($request['FSaleStyleName']) ? $request['FSaleStyleName'] : 0;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FEmpIDName,'FEmpIDName','S',' and ');
		if($FSaleStyleName == 1)
		{
		    $cond->equal('����','FSaleStyleName','S',' and ');
		}
		if($FSaleStyleName == 2)
		{
		    $cond->equal('����','FSaleStyleName','S',' and ');
		}
		//����
		$order = new class_order($request);
		
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FEmpIDName,FSaleStyleName'.$order->getOrder());
		
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);
		$allFProfit =$this->_count($alldata,'FProfit');
		$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
	    $data = array_slice($alldata, $page['offset'], $page['size'] , true);
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('FEmpIDName'  ,$FEmpIDName);
		   $this->_smarty->assign('FSaleStyleName'  ,$FSaleStyleName);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
		   $this->_smarty->assign('allFProfit',$allFProfit);
		   $this->_smarty->assign('allFSaleAmount',$allFSaleAmount);
	       $this->_smarty->display('repsale.FEmpIDName.htm');
	    }
    }
	
	//��ʾ�߼���ѯ����
    function actionrepsaleSearch()
    {
		//�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FCustomerType = isset($request['FCustomerType_name']) ? trim($this->u2gbk($request['FCustomerType_name'])) : null;
		$FBrand   = isset($request['FBrand_name']) ? trim($this->u2gbk($request['FBrand_name'])) : null;
		$FType = isset($request['FType_name']) ? trim($this->u2gbk($request['FType_name'])) : null;
		$FArea = isset($request['FArea_name']) ? trim($this->u2gbk($request['FArea_name'])) : null;
		$FDeptName = isset($request['FDeptName_name']) ? trim($this->u2gbk($request['FDeptName_name'])) : null;
		$FEmpIDName = isset($request['FEmpIDName_name']) ? trim($this->u2gbk($request['FEmpIDName_name'])) : null;
		$FSaleStyleName = isset($request['FSaleStyleName']) ? $request['FSaleStyleName'] : 0;
		$this->_smarty->assign('formdate',$formdate);
		$this->_smarty->assign('todate'  ,$todate);
	    $this->_smarty->assign('FCustomerType',$FCustomerType);
		$this->_smarty->assign('FBrand'  ,$FBrand);
		$this->_smarty->assign('FType',$FType);
		$this->_smarty->assign('FArea'  ,$FArea);
		$this->_smarty->assign('FDeptName',$FDeptName);
		$this->_smarty->assign('FEmpIDName',$FEmpIDName);
		$this->_smarty->assign('FSaleStyleName',$FSaleStyleName);
        $this->_smarty->display('repsaleSearch.htm');	
    }
	
	//������ϸ��
    function actionrepsaleSearchList()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
		$this->sql  = 'select * from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FCustomerType = isset($request['FCustomerType_name']) ? trim($this->u2gbk($request['FCustomerType_name'])) : null;
		$FBrand   = isset($request['FBrand_name']) ? trim($this->u2gbk($request['FBrand_name'])) : null;
		$FType = isset($request['FType_name']) ? trim($this->u2gbk($request['FType_name'])) : null;
		$FArea = isset($request['FArea_name']) ? trim($this->u2gbk($request['FArea_name'])) : null;
		$FDeptName = isset($request['FDeptName_name']) ? trim($this->u2gbk($request['FDeptName_name'])) : null;
		$FEmpIDName = isset($request['FEmpIDName_name']) ? trim($this->u2gbk($request['FEmpIDName_name'])) : null;
		$FSaleStyleName = isset($request['FSaleStyleName']) ? $request['FSaleStyleName'] : 0;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FCustomerType,'FCustomerType','S',' and ');
		$cond->equal($FBrand,'FBrand','S',' and ');	
		$cond->equal($FType,'FType','S',' and ');
		$cond->equal($FArea,'FArea','S',' and ');
		$cond->equal($FDeptName,'FDeptName','S',' and ');
		$cond->equal($FEmpIDName,'FEmpIDName','S',' and ');
		if($FSaleStyleName == 1)
		{
		    $cond->equal('����','FSaleStyleName','S',' and ');
		}
		if($FSaleStyleName == 2)
		{
		    $cond->equal('����','FSaleStyleName','S',' and ');
		}
		//����
		$order = new class_order($request);
		
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);

		$allFProfit =$this->_count($alldata,'FProfit');
		$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
		$data = array_slice($alldata, $page['offset'], $page['size'] , true);
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('FCustomerType',$FCustomerType);
		   $this->_smarty->assign('FBrand'  ,$FBrand);
		   $this->_smarty->assign('FType',$FType);
		   $this->_smarty->assign('FArea'  ,$FArea);
		   $this->_smarty->assign('FDeptName',$FDeptName);
		   $this->_smarty->assign('FEmpIDName',$FEmpIDName);
		   $this->_smarty->assign('FSaleStyleName',$FSaleStyleName);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
		   $this->_smarty->assign('allFProfit',$allFProfit);
		   $this->_smarty->assign('allFSaleAmount',$allFSaleAmount);
	       $this->_smarty->display('repsaleSearchList.htm');
	    }	
    }
	
	//������ϸ��-��ϸ
    function actionrepsaledeList()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('request','controller:string,action:string');
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
		$this->sql  = 'select * from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : null;
	    $todate   = isset($request['todate'])   ? $request['todate']   : null;
		$FA = isset($request['FA']) ? rawurldecode($request['FA']): '';
		$FAV   = isset($request['FAV']) ? rawurldecode($request['FAV']) : null;
		$FB = isset($request['FB']) ? rawurldecode($request['FB']): '';
		$FBV = isset($request['FBV']) ? rawurldecode($request['FBV']) : null;
		$FCustomerType = isset($request['FCustomerType']) ? rawurldecode($request['FCustomerType']): null;
		$FBrand   = isset($request['FBrand']) ? rawurldecode($request['FBrand']) : null;
		$FType = isset($request['FType']) ? rawurldecode($request['FType']): null;
		$FArea = isset($request['FArea']) ? rawurldecode($request['FArea']) : null;
		$FDeptName = isset($request['FDeptName']) ? rawurldecode($request['FDeptName']) : null;
		$FEmpIDName = isset($request['FEmpIDName']) ? rawurldecode($request['FEmpIDName']) : null;
		$FSaleStyleName = isset($request['FSaleStyleName']) ? rawurldecode($request['FSaleStyleName']) : null;
		
		if($FA!='')
		{		
			$FCustomerType  = $FA == 'FCustomerType' ? $FAV: $FCustomerType;
		    $FBrand         = $FA == 'FBrand' ? $FAV: $FBrand;
		    $FType          = $FA == 'FType' ? $FAV: $FType;
		    $FArea          = $FA == 'FArea' ? $FAV: $FArea;
		    $FDeptName      = $FA == 'FDeptName' ? $FAV: $FDeptName;
		    $FEmpIDName     = $FA == 'FEmpIDName' ? $FAV: $FEmpIDName; 
		}
		if($FB!='' && $FA!=$FB)
		{
			$FCustomerType  = $FB == 'FCustomerType' ? $FBV: $FCustomerType;
		    $FBrand         = $FB == 'FBrand' ? $FBV: $FBrand;
		    $FType          = $FB == 'FType' ? $FBV: $FType;
		    $FArea          = $FB == 'FArea' ? $FBV: $FArea;
		    $FDeptName      = $FB == 'FDeptName' ? $FBV: $FDeptName;
		    $FEmpIDName     = $FB == 'FEmpIDName' ? $FBV: $FEmpIDName; 
		}
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FCustomerType,'FCustomerType','S',' and ');
		$cond->equal($FBrand,'FBrand','S',' and ');	
		$cond->equal($FType,'FType','S',' and ');
		$cond->equal($FArea,'FArea','S',' and ');
		$cond->equal($FDeptName,'FDeptName','S',' and ');
		$cond->equal($FEmpIDName,'FEmpIDName','S',' and ');
		$cond->equal($FSaleStyleName,'FSaleStyleName','S',' and ');

		//����
		$order = new class_order($request);
		
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);
		$allFProfit =$this->_count($alldata,'FProfit');
		$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
		$data = array_slice($alldata, $page['offset'], $page['size'] , true);
		
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('FCustomerType',$FCustomerType);
		   $this->_smarty->assign('FBrand'  ,$FBrand);
		   $this->_smarty->assign('FType',$FType);
		   $this->_smarty->assign('FArea'  ,$FArea);
		   $this->_smarty->assign('FDeptName',$FDeptName);
		   $this->_smarty->assign('FEmpIDName',$FEmpIDName);
		   $this->_smarty->assign('FSaleStyleName',$FSaleStyleName);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
		   $this->_smarty->assign('allFProfit',$allFProfit);
		   $this->_smarty->assign('allFSaleAmount',$allFSaleAmount);
	       $this->_smarty->display('repsaledeList.htm');
	    }	
    }
	
	//������ϸ��-���
	function actionrepsaleCombine()
    {
        //�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');

		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FA = isset($request['FA'])&& !empty($request['FA']) ? trim($this->u2gbk($request['FA'])) : '';
		$FB = isset($request['FB'])&& !empty($request['FB'])? trim($this->u2gbk($request['FB'])) : '';
        $FB  = $FA == $FB ? '' : $FB;
	    $_FA = $FA == '' ? '' : $FA.',';
		$_FB = $FB == '' ? '' : $FB.',';
		$cond->between($formdate,$todate,'fdate','D',2);
        $this->sql = 'select '.$_FA.$_FB.'sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
		//����
		$order = new class_order($request);
		
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
        if(trim($_FA.$_FB,',')=='')
		{
		    $alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		}
		else
		{
		    $alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by '.trim($_FA.$_FB,',').$order->getOrder());
		}
	
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);
		$allFProfit =$this->_count($alldata,'FProfit');
		$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
	    $data = array_slice($alldata, $page['offset'], $page['size'] , true);
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('FA'  ,$FA);
		   $this->_smarty->assign('FB'  ,$FB);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
		   $this->_smarty->assign('allFProfit',$allFProfit);
		   $this->_smarty->assign('allFSaleAmount',$allFSaleAmount);
	       $this->_smarty->display('repsale.Combine.htm');
	    }
    }
	
	//������ϸ��
    function actionDeliveryDetail()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select * from v_delivery';
		//��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FCustomers = isset($request['FCustomers']) ? trim($this->u2gbk($request['FCustomers'])) : '';
		$FCustomercode = isset($request['FCustomercode']) ? trim($this->u2gbk($request['FCustomercode'])) : '';
		if(!strpos($FCustomers,','))
			$FCustomercode = $FCustomers;
		else
			if(strlen($FCustomercode)==0)
			{
				$pos = strpos($FCustomers,',');
				$FCustomercode = substr($FCustomers,0,$pos);
			}
			else
			{
				$start = strpos($FCustomers,$FCustomercode);
				$start = $start + strlen($FCustomercode) + 1;
				if($start>=strlen($FCustomers))
				{
					$pos = strpos($FCustomers,',');
					$FCustomercode = substr($FCustomers,0,$pos);
				}
				else
				{
					$pos = strpos($FCustomers,',',$start);
					if(!$pos)
						$FCustomercode = substr($FCustomers,$start);
					else
						$FCustomercode = substr($FCustomers,$start,$pos - $start);
				}
			}
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FCustomercode,'FCustomercode','S',' and ');
		
		//����
		$order = new class_order($request);
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		foreach($alldata as $row)
		{
			$FCustomername = $row['FCustomerName'];
			$FAddress = $row['FAddress'];
			$FProvince = $row['FProvince'];
			$FCity = $row['FCity'];
			$FTel = $row['FTel'];
			$FFax = $row['FFax'];
			$FMobile = $row['FMobile'];
			$FRMB = 'RMB';
			break;
		}
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
	    $data = array_slice($alldata, $page['offset'], $page['size'] , true);
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('FCustomers'  ,$FCustomers);
		   $this->_smarty->assign('FCustomercode'  ,$FCustomercode);
		   $this->_smarty->assign('FCustomername'  ,$FCustomername);
		   $this->_smarty->assign('FAddress'  ,$FAddress);
		   $this->_smarty->assign('FProvince'  ,$FProvince);
		   $this->_smarty->assign('FCity'  ,$FCity);
		   $this->_smarty->assign('FTel'  ,$FTel);
		   $this->_smarty->assign('FFax'  ,$FFax);
		   $this->_smarty->assign('FMobile'  ,$FMobile);
		   $this->_smarty->assign('FRMB'  ,$FRMB);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
	       $this->_smarty->display('kc.DeliveryDetail.htm');
	    }
    }
	
	
	//�տ���ܱ�
    function actionReceivable()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('post','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select * from v_pay';
		//��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		
		//$cond->between($formdate,$todate,'fdate','D',2);
		//$cond->equal($FCustomercode,'FCustomercode','S',' and ');
		
		//����
		$order = new class_order($request);
		//��ȡ��ǰҳ
		$page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
        $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
		//��ȡSQL��ѯ�ļ�¼����
        $page['count']  = count($alldata);
	    //��¼ƫ����
        $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
	    $data = array_slice($alldata, $page['offset'], $page['size'] , true);
		//�����ѯ���
        if(isset($data))
	    {
		   $this->_smarty->assign('formdate',$formdate);
		   $this->_smarty->assign('todate'  ,$todate);
		   $this->_smarty->assign('orderField'    ,$order->getField());
		   $this->_smarty->assign('orderDirection',$order->getDirection());
		   $this->_smarty->assign('page',$page);
		   $this->_smarty->assign('data',$data);
		   $this->_smarty->assign('alldata',$alldata);
	       $this->_smarty->display('repsale.Receivable.htm');
	    }
    }
}
