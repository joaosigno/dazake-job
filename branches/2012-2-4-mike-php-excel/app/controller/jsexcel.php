<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * 定义excel控制器
 *
 */
///////////////////////////////////////////////////////////////////////////
//加载控制器基类
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
	
    //构造函数
    function controller_jsexcel()
    {
	    //初始化模板
	    $this->initView();
	    $this->checkLogin();
		$this->sql  = 'select * from v_salesdetail';
        $this->field['FListEntryID'] = 'FListEntryID';
		$this->field['FOrderBillNo'] = '销售订单号 SO No.';
        $this->field['FBillNo'] = '出库单号 GDN No.';
        $this->field['FDate'] = '销售日期 Date';
        $this->field['FCustomerNumber'] ='客户代码 Customer Code';
        $this->field['FCustomerName'] = '客户名称 Customer Name';
        $this->field['FCustomerType'] = '客户分类 Customer Category';
        $this->field['FArea'] = '销售区域 Sales Region';
        $this->field['FDeptName'] = '部门 Branches';
        $this->field['FEmpIDName'] = '业务员 Sales Representative';
        $this->field['FFullNumber'] = '商品代码 Product Code';
        $this->field['FItemName'] = '商品名称 Product Name';
        $this->field['FItemModel'] = '规格型号 SKU';
        $this->field['FBrand'] = '所属品牌 Brand';
        $this->field['FType'] = '商品分类 Product Category';
        $this->field['FTypeEn'] = 'Product Category';
        $this->field['FSaleStyleName'] = '销售分类 Sales Category';
        $this->field['FUnitIDName'] = '销售单位 Unit';
        $this->field['FSaleAmountIncludeTax'] = '销售收入（含税） Revenue (inc. Tax)';
        $this->field['FSaleAmount'] = '销售收入（不含税） Revenue (exc. VAT)';
        $this->field['FAmount'] = '成本 COGS';
        $this->field['FProfit'] = '毛利 Prime Margin';
        $this->field['FProfitRate'] = '毛利率 PM%';
        $this->field['FExplanation'] = '摘要 Explanation';
        $this->field['FNote'] = '备注 Note' ;
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
		   $this->head[0][] = '销售比重 Sales Weight%';
		   $this->head[0][] = '毛利比重 SW%';
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
	
	//销售明细表
    function actionrepsale()
    {
	    //过滤语句
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		//设置查询语句
		$dbo =& FLEA::getDBO();
		$this->sql  = 'select * from v_salesdetail';
		
	    //查询条件-按日期查询
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$cond->between($formdate,$todate,'fdate','D',2);
		
		//排序
		$order = new class_order($request);
		
		//获取SQL查询的全部记录
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
		$xls = new class_excel();
		
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("repsale");
		
    }
	
	//出库明细表  
	function actionDeliveryDetail()
    {
	    //过滤语句
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		//设置查询语句
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FCustomerType,sum(FSaleAmountIncludeTax) as FSaleAmountIncludeTax ,sum(FSaleAmount) as FSaleAmount,sum(FAmount) as FAmount,sum(FProfit) as FProfit,case when sum(FSaleAmount) = 0 then 0 else sum(FProfit)/sum(FSaleAmount) end FProfitRate from v_salesdetail';
		//查询条件-按日期查询
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FCustomerType = isset($request['FCustomerType']) ? trim(rawurldecode($request['FCustomerType'])) : null;
		$cond->between($formdate,$todate,'fdate','D',2);
		$cond->equal($FCustomerType,'FCustomerType','S',' and ');
		
		//排序
		$order = new class_order($request);
	    
		//获取SQL查询的全部记录
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().' group by FCustomerType '.$order->getOrder());
		
		$xls = new class_excel();
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("DeliveryDetail");
    }

}
