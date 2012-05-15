<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * 定义ajax控制器
 *
 *  ajax控制器提供了ajax处理模块。
 */
///////////////////////////////////////////////////////////////////////////
//加载控制器基类
FLEA::loadClass('controller_base');

class controller_ajax extends controller_base
{
    var $_model;
    
    //构造函数
    function controller_ajax()
    {
	    $this->initView();
	    $this->checkLogin();
    }
    //
    function actionchangepwd()
    {
	    $rbac =& FLEA::getSingleton('FLEA_Rbac');
        $SE = $rbac->getUser();
	  	if(!$SE)
		{
		    $this->writeAjax('300','你无权执行此操作!','','','');
        };
	    //检查信息是否为空
		if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword']))
		{
		    $this->writeAjax('300','提交信息不完整!','','','');
		}
		else
		{
		    $sysuser =& FLEA::getSingleton('model_sysuser');
			if ($sysuser -> changePassword($SE['USERNAME'],$_POST['oldPassword'],$_POST['newPassword']))
			{
			   $this->writeAjax('200','修改成功!', 'navNewsLi','closeCurrent','');
			}
			else
			{
			   $this->writeAjax('300','旧密码输入错误!','','','');
			} 
		}
    }
	
	//
    function actionuseredit()
    {
	    $this->writeAjax('200','保存成功!','','','');
    }
	
	
	
}
