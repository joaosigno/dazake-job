<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * 定义Login控制器
 *  Login 控制器提供了管理员用户登陆，注销登陆，用户注册等功能。
 */
////////////////////////////////////////////////////////////////////////////
//加载控制器基类
FLEA::loadClass('controller_base');
FLEA::loadClass('class_validator');
 
class controller_Login extends controller_base
{
    var $_model;
    var $_title;
    var $_smarty;
	
    //构造函数
    function controller_login()
    {   
        //初始化模板
        $this->initView();
    }
	
	//后台用户登陆页
    function actionindex()
    {		
        $this->_smarty->display('login.htm');
    }	
	
	//后台用户登陆处理
    function actionlogin()
    {		
	    if (!isset($_POST['Username']))
        {
		    js_alert('用户名不能为空！','history.back()'); 
		};
		if (!isset($_POST['password']))
        {
		    js_alert('密码不能为空！','history.back()'); 
		};
		if (!isset($_POST['chkcode']))
        {
		    js_alert('验证码不能为空！','history.back()'); 
		};
		$validator = new class_validator;
        $sysuser =& FLEA::getSingleton('model_sysuser');
	    $imgcode =& FLEA::getSingleton('FLEA_Helper_ImgCode');
		
		//根据用户名查找用户
        $user = $sysuser->findByUserName($_POST['Username']);
		
		//判断用户是否存在
		if (!$user) 
	    {
            js_alert('用户未注册！','history.back()'); 
		}
		//检查密码
		elseif (!$sysuser->checkPassword($_POST['password'],$user[$sysuser->passwordField]))
        {
            js_alert('密码错误！','history.back()'); 
        }
		elseif (!$imgcode->check($_POST['chkcode']))
        {
            js_alert('验证码错误！','history.back()'); 
        }           
		else
		{
		
		    //登录成功，通过 RBAC 保存用户信息和角色
            $data = array();
			$data['UID']      = $user[$sysuser->primaryKey];
            $data['USERNAME'] = $user[$sysuser->usernameField];
			$data['EMAIL']    = $user[$sysuser->emailField];
			$data['TIME']     = date('Y-m-d H:i:s');
			$data['IsSuperUser'] = $user['IsSuperUser'];
            $rbac =& FLEA::getSingleton('FLEA_Rbac');
            $rbac->setUser($data, $sysuser->fetchRoles($user));
            // 进入管理页
           redirect(url('index',''));
			//dump($_SESSION);  
			//dump($user);
		}
		$imgcode->clear();
		
    }	
	
	// 用户注销
    function actionlogout()
	{
        session_destroy();
        js_alert('退出成功！','history.back()');
    }
	
	// 用户注册
    function actionsignup()
	{
        session_destroy();
        $this->_smarty->display('signup.htm');
    }
	
    //获取验证码
    function actionimgCode() 
	{
	    /* FLEA_Helper_ImgCode */
        $imgcode =& FLEA::getSingleton('FLEA_Helper_ImgCode');
        $imgcode->image();
    }
 
}
