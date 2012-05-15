<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * 定义jsreport 结算报表控制器
 *
 */
///////////////////////////////////////////////////////////////////////////
//加载控制器基类
FLEA::loadClass('controller_base');
FLEA::loadClass('class_using');
FLEA::loadClass('class_excel');
FLEA::loadClass('class_conditions');
FLEA::loadClass('class_order');

class controller_jsreport extends controller_base
{
	var $sql;
	
    //构造函数
    function controller_jsreport()
    {
	    //初始化模板
	    $this->initView();
	    $this->checkLogin();
    }
	
    //结算报表管理首页
    function actionindex()
    {
	  
    }
	
	//结算报表
	function actionReceivables()
    {

    }


}
