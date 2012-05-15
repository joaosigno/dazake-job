<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * ����user������
 *
 *  user�������ṩ���û���������ܡ�
 */
///////////////////////////////////////////////////////////////////////////
//���ؿ���������
FLEA::loadClass('controller_base');
FLEA::loadClass('class_using');
FLEA::loadClass('class_excel');
FLEA::loadClass('class_order');

class controller_user extends controller_base
{
    var $_model;
    var $_title;
	
    //���캯��
    function controller_user()
    {
	    //��ʼ��ģ��
	    $this->initView();
	    $this->checkLogin();
    }
	
    //�û�������ҳ
    function actionindex()
    {
	    $this->_model =& FLEA::getSingleton('model_user');
    }
	
	//�鿴�û��б�
    function actionuserlist()
    {
	    $this->_model =& FLEA::getSingleton('model_user');
		$using = new class_using;
		$request = $using->safeUsing('post','controller:string, action:string, orderField:string, orderDirection:string');
		$order          = null;
		$orderField     = null;
		$orderDirection = null;
		//����
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
 
	//�鿴�û���Ϣ
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
		    $this->writeAjax('300','��Ϣ������','','','');
		}
    }
	
	//����û�
    function actionuseradd()
    {
		$this->_smarty->assign('user',null);
		$this->_smarty->display('userview.htm');
    }
	
	//�޸��û���Ϣ
	function actionuseredit()
    {	
		$rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','����Ȩִ�д˲���!','','','');
        };
		
	    $using = new class_using;
		$request = $using->safeUsing('post','UserID:string,FirstName:string, LastName:string, DisplayName:string, password:string, Username:string, Email:email,IsSuperUser:int');
		
		if (!isset($request['UserID']))
		{
            $this->writeAjax('300','��Ϣ������','','','');
		}
	    else
		{
		    //������Ϣ
			
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
			    $this->writeAjax('200','����ɹ�!','','','');
			}
			else
			{
			   $this->writeAjax('300','����ʧ��!','','','');
			}
		}
    }
	
	//ɾ���û�
	function actionuserdelete()
    {
	    $rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','����Ȩִ�д˲���!','','','');
        };
		
	    $using = new class_using;
		$request = $using->safeUsing('get','UserID:int');
		if (!isset($request['UserID']))
		{
            $this->writeAjax('300','��Ϣ������','','','');
		}
		elseif ($request['UserID']=='1')
		{
            $this->writeAjax('300','ϵͳ�˺Ų���ɾ����','','','');
		}
	    else
		{
		    $UserID = (int)$request['UserID'];
			$this->_model =& FLEA::getSingleton('Model_User');
			
            if($this->_model->removeByPkv($UserID))
			{
			    $this->writeAjax('200','ɾ���ɹ�!','','','');
			}
			else
			{
			    $this->writeAjax('300','ɾ��ʧ��!','','','');
			}
		}
    }
	
	//�鿴�û�Ȩ��
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
		    $this->writeAjax('300','��Ϣ������','','','');
		}
	}
	
	//�����û�Ȩ��
	function actionuseractsave()
    {	
		$rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','����Ȩִ�д˲���!','','','');
        };
		
	    $using = new class_using;
		$request = $using->safeUsing('post','UserID:string, FirstName:string, LastName:string, DisplayName:string, password:string, Username:string, Email:email,IsSuperUser:int');
		
		if (!isset($request['UserID']))
		{
            $this->writeAjax('300','��Ϣ������','','','');
		}
	    else
		{
		    //������Ϣ
			$data = array
		    (
                'UserID'  => $request['UserID'],
				'RepAct'  => implode(",",$request['RepAct']),
            );
		    $this->_model =& FLEA::getSingleton('model_user');
			$UsersRepAct = $this->_model->find($request['UserID']);

			if($this->_model->save($data))
			{
			    $this->writeAjax('200','����ɹ�,ע������Ч!','','','');
			}
			else
			{
			   $this->writeAjax('300','����ʧ��!','','','');
			}
		}
    }
	
	//�����û���Ϣ
	function actionuserImport()
    {	
		$rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
		if(!$SE)
		{
		    $this->writeAjax('300','����Ȩִ�д˲���!','','','');
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
