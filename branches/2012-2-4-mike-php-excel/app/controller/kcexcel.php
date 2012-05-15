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

class controller_kcexcel extends controller_base
{
	var $sql;
	var $head;
	var $field;
	var $foot;
	
    //���캯��
    function controller_kcexcel()
    {
	    //��ʼ��ģ��
	    $this->initView();
	    $this->checkLogin();
		$this->field['FCustomerCode'] = '�ͻ�����';
		$this->field['FCustomerName'] = '�ͻ�����';
		$this->field['FDate'] = '�ͻ�����';
		$this->field['FAmount'] = '����˰���';
		$this->field['FAllAmount'] = '��˰���';
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
	
	//������ϸ��  
	function actionDeliveryDetail()
    {
	    //�������
	    $using = new class_using;
	    $request = $using->safeUsing('get','controller:string,action:string');
		
		//���ò�ѯ���
		$dbo =& FLEA::getDBO();
        $this->sql = 'select FCustomerCode,FCustomerName,FDate,FAmount,FAllAmount from v_delivery';
		//��ѯ����-�����ڲ�ѯ
		$cond = new class_conditions;
	    $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	    $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		$FCustomer = isset($request['FCustomer']) ? trim(rawurldecode($request['FCustomer'])) : null;
		$cond->equal($FCustomer,'FCustomerCode','S',' and ');
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
