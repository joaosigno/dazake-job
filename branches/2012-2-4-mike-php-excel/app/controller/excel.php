<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * ����excel������
 *
 */
///////////////////////////////////////////////////////////////////////////
//���ؿ���������
FLEA::loadClass('controller_base');
FLEA::loadClass('class_using');
FLEA::loadClass('class_excel');
FLEA::loadClass('class_conditions');
FLEA::loadClass('class_order');

class controller_excel extends controller_base
{
	var $sql;
	var $head;
	var $field;
	var $foot;
	
    //���캯��
    function controller_excel()
    {
	    //��ʼ��ģ��
	    $this->initView();
	    $this->checkLogin();
		$this->sql  = 'SELECT * FROM [v_salesdetail]';
		$this->field['FOrderBillNo'] = 'SO No.���۶�����';
        $this->field['FBillNo'] = 'GDN No.���ⵥ��';
        $this->field['FVDate'] = 'Date��������';
        $this->field['FCustomerNumber'] ='Customer Code�ͻ�����';
        $this->field['FCustomerName'] = 'Customer Name�ͻ�����';
        $this->field['FCustomerType'] = 'Customer Category�ͻ�����';
        $this->field['FArea'] = 'Sales Region��������';
        $this->field['FDeptName'] = 'Branches����';
        $this->field['FEmpIDName'] = 'Sales Representativeҵ��Ա';
        $this->field['FFullNumber'] = 'Product Code��Ʒ����';
        $this->field['FItemName'] = 'Product Name��Ʒ����';
        $this->field['FItemModel'] = 'SKU����ͺ�';
        $this->field['FBrand'] = 'Brand����Ʒ��';
        $this->field['FType'] = 'Product Category��Ʒ����';
        $this->field['FTypeEn'] = 'Product CategoryӢ����Ʒ����';
        $this->field['FSaleStyleName'] = 'Sales Category���۷���';
        $this->field['FUnitIDName'] = 'Unit���۵�λ';
        $this->field['FSaleAmountIncludeTax'] = 'Revenue (inc. Tax)�������루��˰��';
        $this->field['FSaleAmount'] = 'Revenue (exc. VAT)�������루����˰��';
        $this->field['FAmount'] = 'COGS�ɱ�';
        $this->field['FProfit'] = 'Prime Marginë��';
        $this->field['FProfitRate'] = 'PM%ë����';
		$this->field['FSalesWeight'] = 'Sales Weight%���۱���';
        $this->field['FSW'] = 'SW%ë������';
        $this->field['FExplanation'] = 'ExplanationժҪ';
        $this->field['FNote'] = 'Note��ע' ;
		$this->head[0]=array();
		$this->foot[0]=array();
    }
	
	function actionindex()
    {  
    }
	
    function gethead($data)
    {  
		if($data)
		{
	       foreach (array_keys($data[0]) as $key => $k)
		   {
				if (isset($this->field[$k]))
				{
					$this->head[0][] = $this->field[$k];
				};
		   }
		}
        return	$this->head;	
    }
	
	 function getdata($data)
    {  
		$allFProfit = $this->_count($data,'FProfit');
		$allFSaleAmount =$this->_count($data,'FSaleAmount');
	    foreach ($data as $key => $k)
		{
		   $data[$key]['FSaleAmountIncludeTax']= isset($data[$key]['FSaleAmountIncludeTax']) ? number_format($data[$key]['FSaleAmountIncludeTax'],2,'.',',') : '0.00';
		   $data[$key]['FSaleAmount']= isset($data[$key]['FSaleAmount']) ? number_format($data[$key]['FSaleAmount'],2,'.',',') : '0.00';
		   $data[$key]['FAmount']= isset($data[$key]['FAmount']) ? number_format($data[$key]['FAmount'],2,'.',',') : '0.00';
		   $data[$key]['FProfit']= isset($data[$key]['FProfit']) ? number_format($data[$key]['FProfit'],2,'.',',') : '0.00';
		   $data[$key]['FProfitRate']= isset($data[$key]['FProfitRate']) ? sprintf('%.2f', $data[$key]['FProfitRate'] * 100).'%'  : '';
		   $data[$key]['FSalesWeight']= $allFSaleAmount != 0 ? sprintf('%.2f',$data[$key]['FSaleAmount'] / $allFSaleAmount * 100).'%' : '';
		   $data[$key]['FSW']= $allFProfit !=0 ? sprintf('%.2f',$data[$key]['FProfit'] / $allFProfit * 100).'%' :'';
		}
        return $data;
    }
	
	 function getfoot($data)
    {  
		if($data)
		{
	       foreach (array_keys($data[0]) as $key => $k)
		   {
		        $v = '';
		        if($k == 'FSaleAmountIncludeTax') $v =number_format($this->_count($data,$k),2,'.',',');
                if($k == 'FSaleAmount') $v=number_format($this->_count($data,$k),2,'.',',');
				if($k == 'FAmount') $v=number_format($this->_count($data,$k),2,'.',',');
				if($k == 'FProfit') $v=number_format($this->_count($data,$k),2,'.',',');
				$this->foot[0][] = $v;
		   }
		}
        return	$this->foot;	
    }
	
	//������ϸ��
    function actionrepsale()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
		$this->sql  = 'SELECT [FOrderBillNo], [FBillNo], [FVDate], [FCustomerNumber], [FCustomerName], [FCustomerType], [FArea], [FDeptName], [FEmpIDName], [FFullNumber], [FItemName], [FItemModel], [FBrand], [FType], [FTypeEn], [FSaleStyleName], [FUnitIDName], [FSaleAmountIncludeTax], [FSaleAmount], [FAmount], [FProfit], [FProfitRate], 0.00 AS FSalesWeight, 0.00 AS FSW, [FExplanation], [FNote] FROM [v_salesdetail]';
		
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		echo(@formdate);
		$cond->between($formdate,$todate,'fdate','D',2);
		
		//����
		$order = new class_order($request);
		
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
		$xls = new class_excel();
		
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("repsale");
		
    }
	
	//������ϸ��-���ͻ�����
    function actionrepsaleFCustomerType()
    {
	     //�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FCustomerType,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
		//��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FCustomerType = isset($request['FCustomerType']) ? trim(rawurldecode($request['FCustomerType'])) : null;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FCustomerType,'FCustomerType','S',' and ');
		
		//����
		$order = new class_order($request);
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FCustomerType '.$order->getOrder());
		
		$xls = new class_excel();
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("repsaleFCustomerType");
    }
	
	//������ϸ��-������Ʒ��
    function actionrepsaleFBrand()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FBrand,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate'])    ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])      ? $request['todate']   : date("Y-m-d");
		$FBrand   = isset($request['FBrand']) ? trim(rawurldecode($request['FBrand'])) : null;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FBrand,'FBrand','S',' and ');
		
		//����
		$order = new class_order($request);
		
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FBrand '.$order->getOrder());
		
		$xls = new class_excel();
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("repsaleFBrand");
    }
	
	//������ϸ��-����Ʒ����
	function actionrepsaleFType()
    {
		//�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FType,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FType = isset($request['FType']) ? trim(rawurldecode($request['FType'])) : null;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FType,'FType','S',' and ');
		
		//����
		$order = new class_order($request);
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FType '.$order->getOrder());

		$xls = new class_excel();
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("repsaleFType");
    }
	
	//������ϸ��-������
	function actionrepsaleFArea()
    {
	 	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
		$this->sql = 'select FArea,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FArea = isset($request['FArea']) ? trim(rawurldecode($request['FArea'])) : null;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FArea,'FArea','S',' and ');
		
		//����
		$order = new class_order($request);
		
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FArea '.$order->getOrder());
		
		$xls = new class_excel();
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("repsaleFArea");
    }
	
    //������ϸ��-������
	function actionrepsaleFDeptName()
    {
	   	//�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FDeptName,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FDeptName = isset($request['FDeptName']) ? trim(rawurldecode($request['FDeptName'])) : null;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FDeptName,'FDeptName','S',' and ');
		
		//����
		$order = new class_order($request); 
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FDeptName '.$order->getOrder());
		
		$xls = new class_excel();
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("repsaleFDeptName");
    }
	
	//������ϸ��-��ҵ��Ա
	function actionrepsaleFEmpIDName()
    {
        //�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');

		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FEmpIDName,FSaleStyleName,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FEmpIDName = isset($request['FEmpIDName']) ? trim(rawurldecode($request['FEmpIDName'])) : null;
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
	    
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FEmpIDName,FSaleStyleName'.$order->getOrder());

		$xls = new class_excel();
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("repsaleFEmpIDName");
    }
	
	//������ϸ�� �߼���ѯ
    function actionrepsaleSearchList()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
		$this->sql  = 'select * from v_salesdetail';
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FCustomerType = isset($request['FCustomerType']) ? trim(rawurldecode($request['FCustomerType'])) : null;
		$FBrand   = isset($request['FBrand']) ? trim(rawurldecode($request['FBrand'])) : null;
		$FType = isset($request['FType']) ? trim(rawurldecode($request['FTypee'])) : null;
		$FArea = isset($request['FArea']) ? trim(rawurldecode($request['FArea'])) : null;
		$FDeptName = isset($request['FDeptName']) ? trim(rawurldecode($request['FDeptName'])) : null;
		$FEmpIDName = isset($request['FEmpIDName']) ? trim(rawurldecode($request['FEmpIDName'])) : null;
		$FSaleStyleName = isset($request['FSaleStyleName']) ? trim(rawurldecode($request['FSaleStyleName'])) : 0;
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
		
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
		$xls = new class_excel();
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("repsaleSearchList");
		
    }
	
	//������ϸ��-��ϸ
    function actionrepsaledeList()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
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
		
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
  		$xls = new class_excel();
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("repsaledeList");
    }
	
	//������ϸ��-���
	function actionrepsaleCombine()
    {
        //�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');

		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FA = isset($request['FA'])&& !empty($request['FA']) ? trim(rawurldecode($request['FA'])) : '';
		$FB = isset($request['FB'])&& !empty($request['FB'])? trim(rawurldecode($request['FB'])) : '';
        $FB  = $FA == $FB ? '' : $FB;
	    $_FA = $FA == '' ? '' : $FA.',';
		$_FB = $FB == '' ? '' : $FB.',';
		$cond->between($formdate,$todate,'fdate','D',2);
        $this->sql = 'select '.$_FA.$_FB.'sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
		//����
		$order = new class_order($request);
		 
        if(trim($_FA.$_FB,',')=='')
		{
		    $alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		}
		else
		{
		    $alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by '.trim($_FA.$_FB,',').$order->getOrder());
		}
	
		$xls = new class_excel();
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("repsaleCombine");
    }
	
	//���۷�����
    function actionDeliveryDetail()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
		$this->sql  = 'select * from v_delivery';
		
	    //��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$cond->between($formdate,$todate,'fdate','D',2);
		
		//����
		$order = new class_order($request);
		
		//��ȡSQL��ѯ��ȫ����¼
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
		$xls = new class_excel();
		
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("DeliveryDetail");
		
    }
}
