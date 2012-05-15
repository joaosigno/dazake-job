<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * ����kcreport ��汨�������
 *
 */
///////////////////////////////////////////////////////////////////////////
//���ؿ���������
FLEA::loadClass('controller_base');
FLEA::loadClass('class_using');
FLEA::loadClass('class_excel');
FLEA::loadClass('class_conditions');
FLEA::loadClass('class_order');

class controller_kcreport extends controller_base
{
	var $sql;
	var $_model;
	
    //���캯��
    function controller_kcreport()
    {
	    //��ʼ��ģ��
	    $this->initView();
	    $this->checkLogin();
    }
	
    //��汨�������ҳ
    function actionindex()
    {
	  
    }
	
	//������ϸ�� ��ѯ 
	function actionDeliveryDetail()
    {
	    $this->_smarty->display('kc.DeliveryDetail.htm');
    }
	
	//������ϸ�� - ���  
	function actionDeliveryDetailList()
    {
        //�������
	    $using = new class_using;
	    $request = $using->safeUsing('request','controller:string,action:string');
		$this->_model =& FLEA::getSingleton('model_rep');//������
		$rep  =  $this->_model->find(array('ID' => $request['kcreport'], 'ID' => $request['actionDeliveryDetailList']));
	    if($rep)
	    {
	        $this->_model =& FLEA::getSingleton('model_grid');//���ֶ�
		    $grid = $this->_model->findAll(array('RepID' => $rep['ID']));
		
		    //���ò�ѯ���
		    $dbo =& FLEA::getDBO();
            $this->sql = $rep['select FCustomerCode,FCustomerName,FDate,FSODate from v_delivery'];
		
		    //��ѯ����-�����ڲ�ѯ
			///�˴����޸�>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	    	$cond = new class_conditions;
	        $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	        $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		    $FCustomer = isset($request['FCustomer']) ? trim($this->u2gbk($request['FCustomer'])) : null;
		    $cond->between($formdate,$todate,'FDate','D',2);
		    $cond->equal($FCustomer,'FCustomerCode','S',' and ');
		    ///�˴����޸�<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
	
		    //����
		    $order = new class_order($request);
		    //��ȡ��ǰҳ
		    $page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
            $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
			echo $this->sql;
		    //��ȡSQL��ѯ��ȫ����¼
		    $alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
		    //��ȡSQL��ѯ�ļ�¼����
            $page['count']  = count($alldata);
		
		    //$allFProfit =$this->_count($alldata,'FProfit');
		    //$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	        //��¼ƫ����
            $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
	        $data = array_slice($alldata, $page['offset'], $page['size'] , true);

		    //�����ѯ���
            if(isset($data))
	        {
			    ///�˴����޸�>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		        $this->_smarty->assign('formdate',$formdate);
		        $this->_smarty->assign('todate'  ,$todate);
		        $this->_smarty->assign('FCustomer'  ,$FCustomer);
				///�˴����޸�<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
				
		        $this->_smarty->assign('orderField'    ,$order->getField());
		        $this->_smarty->assign('orderDirection',$order->getDirection());
		        $this->_smarty->assign('page',$page);
		        $this->_smarty->assign('data',$data);
		        $this->_smarty->assign('grid',$grid);
		        $this->_smarty->assign('alldata',$alldata);
		        $this->_smarty->assign('allFProfit',$allFProfit);
		        $this->_smarty->assign('allFSaleAmount',$allFSaleAmount);
	            $this->_smarty->display('kc.DeliveryDetailList.htm');
	        }
	    }
	    else
	    {
		    $this->_smarty->display('norepinfo.htm');
	    }
    }


}
