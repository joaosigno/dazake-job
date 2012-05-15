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

class controller_jsexcel extends controller_base
{
	var $sql;
	var $head;
	var $field;
	var $foot;
	
    //���캯��
    function controller_jsexcel()
    {
	    //��ʼ��ģ��
	    $this->initView();
	    $this->checkLogin();
		$this->sql  = 'select * from v_salesdetail';
        $this->field['FListEntryID'] = 'FListEntryID';
		$this->field['FOrderBillNo'] = '���۶����� SO No.';
        $this->field['FBillNo'] = '���ⵥ�� GDN No.';
        $this->field['FDate'] = '�������� Date';
        $this->field['FCustomerNumber'] ='�ͻ����� Customer Code';
        $this->field['FCustomerName'] = '�ͻ����� Customer Name';
        $this->field['FCustomerType'] = '�ͻ����� Customer Category';
        $this->field['FArea'] = '�������� Sales Region';
        $this->field['FDeptName'] = '���� Branches';
        $this->field['FEmpIDName'] = 'ҵ��Ա Sales Representative';
        $this->field['FFullNumber'] = '��Ʒ���� Product Code';
        $this->field['FItemName'] = '��Ʒ���� Product Name';
        $this->field['FItemModel'] = '����ͺ� SKU';
        $this->field['FBrand'] = '����Ʒ�� Brand';
        $this->field['FType'] = '��Ʒ���� Product Category';
        $this->field['FTypeEn'] = 'Product Category';
        $this->field['FSaleStyleName'] = '���۷��� Sales Category';
        $this->field['FUnitIDName'] = '���۵�λ Unit';
        $this->field['FSaleAmountIncludeTax'] = '�������루��˰�� Revenue (inc. Tax)';
        $this->field['FSaleAmount'] = '�������루����˰�� Revenue (exc. VAT)';
        $this->field['FAmount'] = '�ɱ� COGS';
        $this->field['FProfit'] = 'ë�� Prime Margin';
        $this->field['FProfitRate'] = 'ë���� PM%';
        $this->field['FExplanation'] = 'ժҪ Explanation';
        $this->field['FNote'] = '��ע Note' ;
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
		      $this->head[0][] = isset($this->field[$k]) ? $this->field[$k] : $k;
		   }
		   $this->head[0][] = '���۱��� Sales Weight%';
		   $this->head[0][] = 'ë������ SW%';
		}
        return	$this->head;	
    }
	
	 function getdata($data)
    {  
		$allFProfit = $this->_count($data,'FProfit');
		$allFSaleAmount =$this->_count($data,'FSaleAmount');
	    foreach ($data as $key => $k)
		{
		   $data[$key]['FSaleAmountIncludeTax']= isset($data[$key]['FSaleAmountIncludeTax']) ? sprintf('%.2f', $data[$key]['FSaleAmountIncludeTax'])  : 0;
		   $data[$key]['FSaleAmount']= isset($data[$key]['FSaleAmount']) ? sprintf('%.2f', $data[$key]['FSaleAmount'])  :0;
		   $data[$key]['FAmount']= isset($data[$key]['FAmount']) ? sprintf('%.2f', $data[$key]['FAmount']) : 0;
		   $data[$key]['FProfit']= isset($data[$key]['FProfit']) ? sprintf('%.2f', $data[$key]['FProfit']) : 0;
		   $data[$key]['FProfitRate']= isset($data[$key]['FProfitRate']) ? sprintf('%.2f', $data[$key]['FProfitRate']).'%'  : '';
		   $data[$key][]= $allFSaleAmount != 0 ? sprintf('%.2f',$data[$key]['FSaleAmount'] / $allFSaleAmount * 100).'%' : '';
		   $data[$key][]= $allFProfit !=0 ? sprintf('%.2f',$data[$key]['FProfit'] / $allFProfit * 100).'%' :'';  
            if (isset($data[$key]['FListEntryID']))
		    {
		       $data[$key]['FListEntryID']='';
		    };  
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
		        if($k == 'FSaleAmountIncludeTax') $v =sprintf('%.2f', $this->_count($data,$k));
                if($k == 'FSaleAmount') $v=sprintf('%.2f', $this->_count($data,$k));
				if($k == 'FAmount') $v=sprintf('%.2f', $this->_count($data,$k));
				if($k == 'FProfit') $v=sprintf('%.2f', $this->_count($data,$k));
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
		$this->sql  = 'select * from v_salesdetail';
		
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
        $xls->generateXML("repsale");
		
    }
	
	//������ϸ��  
	function actionDeliveryDetail()
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
        $xls->generateXML("DeliveryDetail");
    }

}
