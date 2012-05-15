<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * 定义kcreport 库存报表控制器
 *
 */
///////////////////////////////////////////////////////////////////////////
//加载控制器基类
FLEA::loadClass('controller_base');
FLEA::loadClass('class_using');
FLEA::loadClass('class_excel');
FLEA::loadClass('class_conditions');
FLEA::loadClass('class_order');

class controller_kcreport extends controller_base
{
	var $sql;
	var $_model;
	
    //构造函数
    function controller_kcreport()
    {
	    //初始化模板
	    $this->initView();
	    $this->checkLogin();
    }
	
    //库存报表管理首页
    function actionindex()
    {
	  
    }
	
	//出库明细表 查询 
	function actionDeliveryDetail()
    {
	    $this->_smarty->display('kc.DeliveryDetail.htm');
    }
	
	//出库明细表 - 结果  
	function actionDeliveryDetailList()
    {
        //过滤语句
	    $using = new class_using;
	    $request = $using->safeUsing('request','controller:string,action:string');
		$this->_model =& FLEA::getSingleton('model_rep');//出货表
		$rep  =  $this->_model->find(array('ID' => $request['kcreport'], 'ID' => $request['actionDeliveryDetailList']));
	    if($rep)
	    {
	        $this->_model =& FLEA::getSingleton('model_grid');//表字段
		    $grid = $this->_model->findAll(array('RepID' => $rep['ID']));
		
		    //设置查询语句
		    $dbo =& FLEA::getDBO();
            $this->sql = $rep['select FCustomerCode,FCustomerName,FDate,FSODate from v_delivery'];
		
		    //查询条件-按日期查询
			///此处可修改>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	    	$cond = new class_conditions;
	        $formdate = isset($request['formdate']) ? $request['formdate'] : date("Y-m-d");
	        $todate   = isset($request['todate'])   ? $request['todate']   : date("Y-m-d");
		    $FCustomer = isset($request['FCustomer']) ? trim($this->u2gbk($request['FCustomer'])) : null;
		    $cond->between($formdate,$todate,'FDate','D',2);
		    $cond->equal($FCustomer,'FCustomerCode','S',' and ');
		    ///此处可修改<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
	
		    //排序
		    $order = new class_order($request);
		    //获取当前页
		    $page['cid']  = isset($request['pageNum']) && intval($request['pageNum'])> 0 ? intval($request['pageNum']) : 1;
            $page['size'] = isset($request['numPerPage']) && intval($request['numPerPage'])> 0 ? intval($request['numPerPage']) : 20;  
			echo $this->sql;
		    //获取SQL查询的全部记录
		    $alldata = $dbo->getAll($this->sql.$cond->getWhere().$order->getOrder());
		
		    //获取SQL查询的记录总数
            $page['count']  = count($alldata);
		
		    //$allFProfit =$this->_count($alldata,'FProfit');
		    //$allFSaleAmount =$this->_count($alldata,'FSaleAmount');
	        //记录偏移量
            $page['offset'] = ($page['cid'] - 1) * $page['size'] > $page['count'] ? $page['count'] : ($page['cid'] - 1) * $page['size'];
	        $data = array_slice($alldata, $page['offset'], $page['size'] , true);

		    //处理查询结果
            if(isset($data))
	        {
			    ///此处可修改>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		        $this->_smarty->assign('formdate',$formdate);
		        $this->_smarty->assign('todate'  ,$todate);
		        $this->_smarty->assign('FCustomer'  ,$FCustomer);
				///此处可修改<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
				
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
