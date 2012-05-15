<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * 定义user控制器
 *
 *  user控制器提供了用户管理管理功能。
 */
///////////////////////////////////////////////////////////////////////////
//加载控制器基类
FLEA::loadClass('controller_base');
FLEA::loadClass('class_using');
FLEA::loadClass('class_excel');
FLEA::loadClass('class_order');

class controller_user extends controller_base
{
    var $_model;
    var $_title;
	
    //构造函数
    function controller_user()
    {
	    //初始化模板
	    $this->initView();
	    $this->checkLogin();
    }
	
    //用户管理首页
    function actionindex()
    {
	    $this->_model =& FLEA::getSingleton('model_user');
    }
	
	//查看用户列表
    function actionuserlist()
    {
	    $this->_model =& FLEA::getSingleton('model_user');
		$using = new class_using;
		$request = $using->safeUsing('post','controller:string, action:string, orderField:string, orderDirection:string');
		$order          = null;
		$orderField     = null;
		$orderDirection = null;
		//排序
		$order = new class_order($request);
        $users = $this->_model->findAll(null,trim($order->getOrder(),'order by'));
		if (isset($users))
		{
		    $this->_smarty->assign('orderField',$orderField);
            $this->_smarty->assign('orderDirection',$orderDirection);
		    $this->_smarty->assign('users',$users);
		    $this->_smarty->display('userlist.htm');
		}
    }
 
	//查看用户信息
    function actionuserview()
    {
	    $using = new class_using;
		$request = $using->safeUsing('get','controller:string, UserID:string, action:string');
     
		if (isset($request['UserID']))
		{
	        $UserID = $request['UserID'];
		    $this->_model =& FLEA::getSingleton('model_user');
            $user = $this->_model->find($UserID);
		    if (isset($user))
		    {
		       $this->_smarty->assign('user',$user);
		       $this->_smarty->display('userview.htm');
		    }
		}
	    else
	    {
		    $this->writeAjax('300','信息不完整','','','');
		}
    }
	
	//添加用户
    function actionuseradd()
    {
		$this->_smarty->assign('user',null);
		$this->_smarty->display('userview.htm');
    }
	
	//修改用户信息
	function actionuseredit()
    {	
		$rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','你无权执行此操作!','','','');
        };
		
	    $using = new class_using;
		$request = $using->safeUsing('post','UserID:string,FirstName:string, LastName:string, DisplayName:string, password:string, Username:string, Email:email,IsSuperUser:int');
		
		if (!isset($request['UserID']))
		{
            $this->writeAjax('300','信息不完整','','','');
		}
	    else
		{
		    //保存信息
			
		    $this->_model =& FLEA::getSingleton('model_user');
            $data = array
		    (
                'UserID'         => $this->u2gbk($request['UserID']),
				'Username'       => $this->u2gbk($request['Username']),
				'password'       => $this->u2gbk($request['password']),
				'FirstName'      => $this->u2gbk($request['FirstName']),
				'LastName'       => $this->u2gbk($request['LastName']),
				'DisplayName'    => $this->u2gbk($request['DisplayName']),
				'Email'          => $this->u2gbk($request['Email']),
				'IsSuperUser'    => $this->u2gbk($request['IsSuperUser']),
            );
            if($this->_model->save($data))
			{
			    $this->writeAjax('200','保存成功!','','','');
			}
			else
			{
			   $this->writeAjax('300','保存失败!','','','');
			}
		}
    }
	
	//删除用户
	function actionuserdelete()
    {
	    $rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','你无权执行此操作!','','','');
        };
		
	    $using = new class_using;
		$request = $using->safeUsing('get','UserID:int');
		if (!isset($request['UserID']))
		{
            $this->writeAjax('300','信息不完整','','','');
		}
		elseif ($request['UserID']=='1')
		{
            $this->writeAjax('300','系统账号不能删除！','','','');
		}
	    else
		{
		    $UserID = (int)$request['UserID'];
			$this->_model =& FLEA::getSingleton('Model_User');
			
            if($this->_model->removeByPkv($UserID))
			{
			    $this->writeAjax('200','删除成功!','','','');
			}
			else
			{
			    $this->writeAjax('300','删除失败!','','','');
			}
		}
    }
	
	//查看用户权限
	function actionuseractview()
    {
        $using = new class_using;
		$request = $using->safeUsing('get','controller:string, UserID:string, action:string');
     
		if (isset($request['UserID']))
		{
	        $UserID = $request['UserID'];
		    $this->_model =& FLEA::getSingleton('model_user');
            $user = $this->_model->find($UserID);
			$RepAct = explode(',',$user['RepAct']);
		    if (isset($user))
		    {
		       $this->_smarty->assign('user',$user);
			   $this->_smarty->assign('RepAct',$RepAct);
		       $this->_smarty->display('useractview.htm');
		    }
		}
	    else
	    {
		    $this->writeAjax('300','信息不完整','','','');
		}
	}
	
	//保存用户权限
	function actionuseractsave()
    {	
		$rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','你无权执行此操作!','','','');
        };
		
	    $using = new class_using;
		$request = $using->safeUsing('post','UserID:string, FirstName:string, LastName:string, DisplayName:string, password:string, Username:string, Email:email,IsSuperUser:int');
		
		if (!isset($request['UserID']))
		{
            $this->writeAjax('300','信息不完整','','','');
		}
	    else
		{
		    //保存信息
			$data = array
		    (
                'UserID'  => $request['UserID'],
				'RepAct'  => implode(",",$request['RepAct']),
            );
		    $this->_model =& FLEA::getSingleton('model_user');
			$UsersRepAct = $this->_model->find($request['UserID']);

			if($this->_model->save($data))
			{
			    $this->writeAjax('200','保存成功,注销后生效!','','','');
			}
			else
			{
			   $this->writeAjax('300','保存失败!','','','');
			}
		}
    }
	
	//导入用户信息
	function actionuserImport()
    {	
		$rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','你无权执行此操作!','','','');
        };
		
	    $using = new class_using;
		$request = $using->safeUsing('post','UserID:string');
		$dbo =& FLEA::getDBO();
		$data=$dbo->getAll('select t_user.FName AS Username,password=1,IsSuperUser=0,t_user.FName as DisplayName from t_user where t_user.FName not in(select srep_user.Username as FName from srep_user) and  t_user.FUserID > 16000 and  t_user.FName<>'."''");
        $this->_model =& FLEA::getSingleton('model_user');
        $this->_model->saveRowset($data);
		if (isset($data))
		{
		    $this->_smarty->assign('users',$data);
		    $this->_smarty->display('userimport.htm');
		}
    }

}
