<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * 定义Index控制器
 *
 */
////////////////////////////////////////////////////////////////////////////
//加载控制器基类
FLEA::loadClass('controller_base');

class controller_index extends controller_base
{  
	var $_model;
    var $_title;
	
    //构造函数
    function controller_index()
    {
     	//初始化模板
	    $this->initView();
	    $this->checkLogin();
    }
	
    //首页
    function actionindex()
    {	
		//设置标题
		$this->_title = '管理首页';
			
		$rbac =& FLEA::getSingleton('FLEA_Rbac');
        $user = $rbac->getUser();
		//模板赋值
		$this->_model =& FLEA::getSingleton('model_user');
        $_user = $this->_model->find($user['UID']);
		if(isset($_user))
		{
			$this->_smarty->assign('RepAct',explode(',',$_user['RepAct']));
			$this->_smarty->assign('title',$this->_title);
            $this->_smarty->display('main.htm');	 
		}
    }
}
