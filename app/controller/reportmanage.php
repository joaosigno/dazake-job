<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * 定义reportmanage控制器
 *
 */
///////////////////////////////////////////////////////////////////////////
//加载控制器基类
FLEA::loadClass('controller_base');
FLEA::loadClass('class_using');
FLEA::loadClass('class_excel');
FLEA::loadClass('class_conditions');
FLEA::loadClass('class_order');

class controller_reportmanage extends controller_base
{
	var $sql;
	
    //构造函数
    function controller_reportmanage()
    {
	    //初始化模板
	    $this->initView();
	    $this->checkLogin();
    }
	
    //结算报表管理首页
    function actionindex()
    {
	  
    }
	
	//报表列表
    function actionreplist()
    {
        $this->_model =& FLEA::getSingleton('model_rep');
		$using = new class_using;
		$request = $using->safeUsing('post','controller:string, action:string, orderField:string, orderDirection:string');
		$order          = null;
		$orderField     = null;
		$orderDirection = null;
		//排序
		$order = new class_order($request);
        $rep = $this->_model->findAll(null,trim($order->getOrder(),'order by'));
		if (isset($rep))
		{
		    $this->_smarty->assign('orderField',$orderField);
            $this->_smarty->assign('orderDirection',$orderDirection);
		    $this->_smarty->assign('rep',$rep);
		    $this->_smarty->display('replist.htm');
		}
    }
	
	//添加报表
    function actionrepadd()
    {
		$this->_smarty->assign('rep',null);
		$this->_smarty->display('repview.htm');
    }
	
	//修改或添加报表
	function actionrepsave()
    {	
		$rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','你无权执行此操作!','','','');
        };
		
	    $using = new class_using;
		$request = $using->safeUsing('post','ID:int, RepName:string, Caption:string, SQLTXT:string, Ctrl:string, Fun:string, Memo:string');
		
		if (!isset($request['ID']))
		{
            $this->writeAjax('300','信息不完整','','','');
		}
	    else
		{
		    //保存信息
			
		    $this->_model =& FLEA::getSingleton('model_rep');
            $data = array
		    (
                'ID'         => $this->u2gbk($request['ID']),
				'RepName'    => $this->u2gbk($request['RepName']),
				'Caption'    => $this->u2gbk($request['Caption']),
				'SQLTXT'     => $this->u2gbk($request['SQLTXT']),
				'Controller' => $this->u2gbk($request['Ctrl']),
				'Fun'        => $this->u2gbk($request['Fun']),
				'Memo'       => $this->u2gbk($request['Memo'])
            );
            if($this->_model->save($data))
			{
			    $this->writeAjax('200','保存成功!','reportlist','closeCurrent','');
			}
			else
			{
			   $this->writeAjax('300','保存失败!','','','');
			}
		}
    }
	
	//删除报表
	function actionrepdelete()
    {
	    $rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','你无权执行此操作!','','','');
        };
		
	    $using = new class_using;
		$request = $using->safeUsing('get','ID:int');
		if (!isset($request['ID']))
		{
            $this->writeAjax('300','信息不完整','','','');
		}
	    else
		{
		    $ID = (int)$request['ID'];
			$this->_model =& FLEA::getSingleton('model_rep');
			
            if($this->_model->removeByPkv($ID))
			{
			    $this->writeAjax('200','删除成功!','','','');
			}
			else
			{
			    $this->writeAjax('300','删除失败!','','','');
			}
		}
    }
	
    //查看或编辑报表
	function actionrepview()
    {
        $using = new class_using;
		$request = $using->safeUsing('get','controller:string, ID:int, action:string');
     
		if (isset($request['ID']))
		{
	        $ID = (int)$request['ID'];
			
		    $this->_model =& FLEA::getSingleton('model_rep');
            $rep = $this->_model->find($ID);
			
			$this->_model =& FLEA::getSingleton('model_grid');
		    $grid =  $this->_model->findAll(array('RepID' => $ID));
			
		    if(isset($rep))
		    {
		       $this->_smarty->assign('rep',$rep);
			   $this->_smarty->assign('grid',$grid);
		       $this->_smarty->display('repview.htm');
		    }
		}
	    else
	    {
		    $this->writeAjax('300','信息不完整','','','');
		}
    }
	
	//字段列表
	function actionfldlist()
    {
        $using = new class_using;
		$request = $using->safeUsing('get','controller:string, action:string, ID:int');
     
		if (isset($request['ID']))
		{
	        $ID = (int)$request['ID'];
			
		    $this->_model =& FLEA::getSingleton('model_rep');
            $rep = $this->_model->find($ID);
			
			$this->_model =& FLEA::getSingleton('model_grid');
		    $grid =  $this->_model->findAll(array('RepID' => $ID));
			
		    if(isset($rep))
		    {
		       $this->_smarty->assign('rep',$rep);
			   $this->_smarty->assign('grid',$grid);
		       $this->_smarty->display('fldlist.htm');
		    }
		}
	    else
	    {
		    $this->writeAjax('300','信息不完整','','','');
		}
    }
	
	//添加字段
    function actionfldadd()
    {
	    $using = new class_using;
		$request = $using->safeUsing('get','controller:string, action:string,RepID:int');
		$this->_smarty->assign('grid',null);
		$this->_smarty->assign('RepID',(int)$request['RepID']);
		$this->_smarty->display('fldview.htm');
    }
	
	//查看或编辑字段
	function actionfldview()
    {
        $using = new class_using;
		$request = $using->safeUsing('get','controller:string, action:string, ID:int, RepID:int');
     
		if (isset($request['ID']))
		{
	        $ID = (int)$request['ID'];
		
			$this->_model =& FLEA::getSingleton('model_grid');
		    $grid =  $this->_model->find($ID);
			
		    if(isset($grid))
		    {
			   $this->_smarty->assign('grid',$grid);
			   $this->_smarty->assign('RepID',(int)$request['RepID']);
		       $this->_smarty->display('fldview.htm');
		    }
		}
	    else
	    {
		    $this->writeAjax('300','信息不完整','','','');
		}
    }

	//修改或添加报表
	function actionfldsave()
    {	
		$rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','你无权执行此操作!','','','');
        };
		
	    $using = new class_using;
		$request = $using->safeUsing('post','ID:int, RepID:int, FldName:string, Caption:string, OrderField:string, FWidth:int, OrderNum:int, IsPrint:int, IsExcel:int, Align:int, SumType:int, FormatStr:string');
		
		if (!isset($request['ID']))
		{
            $this->writeAjax('300','信息不完整','','','');
		}
	    else
		{
		    //保存信息
			
		    $this->_model =& FLEA::getSingleton('model_grid');
            $data = array
		    (
                'ID'         => $this->u2gbk($request['ID']),
				'RepID'      => $this->u2gbk($request['RepID']),
				'FldName'    => $this->u2gbk($request['FldName']),
				'Caption'    => $this->u2gbk($request['Caption']),
				'OrderField' => $this->u2gbk($request['OrderField']),
				'FWidth'     => $this->u2gbk($request['FWidth']),
				'OrderNum'   => $this->u2gbk($request['OrderNum']),
				'IsPrint'    => $this->u2gbk($request['IsPrint']),
				'IsExcel'    => $this->u2gbk($request['IsExcel']),
				'Align'      => $this->u2gbk($request['Align']),
				'SumType'    => $this->u2gbk($request['SumType']),
				'FormatStr'  => $this->u2gbk($request['FormatStr'])
            );
            if($this->_model->save($data))
			{
			    $this->writeAjax('200','保存成功!','fldlist','closeCurrent','');
			}
			else
			{
			   $this->writeAjax('300','保存失败!','','','');
			}
		}
    }
	
	//删除字段
	function actionflddelete()
    {
	    $rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','你无权执行此操作!','','','');
        };
		
	    $using = new class_using;
		$request = $using->safeUsing('get','ID:int');
		if (!isset($request['ID']))
		{
            $this->writeAjax('300','信息不完整','','','');
		}
	    else
		{
		    $ID = (int)$request['ID'];
			$this->_model =& FLEA::getSingleton('model_grid');
			
            if($this->_model->removeByPkv($ID))
			{
			    $this->writeAjax('200','删除成功!','','','');
			}
			else
			{
			    $this->writeAjax('300','删除失败!','','','');
			}
		}
    }
	


}
