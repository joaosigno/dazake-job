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

class controller_kcexcel extends controller_base
{
	var $sql;
	var $head;
	var $field;
	var $foot;
	
    //构造函数
    function controller_kcexcel()
    {
	    //初始化模板
	    $this->initView();
	    $this->checkLogin();
		$this->field['FCustomerCode'] = '客户代码';
		$this->field['FCustomerName'] = '客户名称';
		$this->field['FDate'] = '送货日期';
		$this->field['FAmount'] = '不含税金额';
		$this->field['FAllAmount'] = '含税金额';
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
		}
        return	$this->head;	
    }
	
	 function getdata($data)
    {  
		$FAmount = $this->_count($data,'FAmount');
		$FAllAmount =$this->_count($data,'FAllAmount');
	    foreach ($data as $key => $k)
		{
		   $data[$key]['FAmount']= isset($data[$key]['FAmount']) ? sprintf('%.2f', $data[$key]['FAmount'])  : 0;
		   $data[$key]['FAllAmount']= isset($data[$key]['FAllAmount']) ? sprintf('%.2f', $data[$key]['FAllAmount'])  :0;
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
		        if($k == 'FAmount') $v =sprintf('%.2f', $this->_count($data,$k));
                if($k == 'FAllAmount') $v=sprintf('%.2f', $this->_count($data,$k));
				$this->foot[0][] = $v;
		   }
		}
        return	$this->foot;	
    }
	
	//出库明细表  
	function actionDeliveryDetail()
    {
	    //过滤语句
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		//设置查询语句
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FCustomerCode,FCustomerName,FDate,FAmount,FAllAmount from v_delivery';
		//查询条件-按日期查询
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FCustomer = isset($request['FCustomer']) ? trim(rawurldecode($request['FCustomer'])) : null;
		$cond->equal($FCustomer,'FCustomerCode','S',' and ');
		$cond->between($formdate,$todate,'fdate','D',2);
		
		//排序
		$order = new class_order($request);
	    
		//获取SQL查询的全部记录
		$alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
		$xls = new class_excel();
		$xls->addArray($this->gethead($alldata));
        $xls->addArray($this->getdata($alldata));
		$xls->addArray($this->getfoot($alldata));
        $xls->generateXML("DeliveryDetail");
    }

}
