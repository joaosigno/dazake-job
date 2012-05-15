<?php
/////////////////////////////////////////////////////////////////////////////
/*
 * Controller_Base 是控制器的基类，提供一些公共基础的方法
 */
////////////////////////////////////////////////////////////////////////////
class controller_base extends FLEA_Controller_Action
{
	var $_smarty;
    //*构造函数
    function controller_base() 
	{  
    }
	
	function _count($data,$col,$format=null,$datatype='')
	{
	    $c = 0;
		foreach($data as $row)
		{
			if(isset($format))
			{
			    $c = $c + sprintf($format,$row[$col]);
			}
			else
			{
			    $c = $c + $row[$col];
			}
		}
	    return $datatype=='money' ? number_format($c,2,'.',',') : $c;
	 
	}
		
	function initView()
	{
		function _count($params,$format=null,$datatype='')
	    {
	        extract($params);
		    $c = 0;
		    foreach($data as $row)
		    {
			   if(isset($format))
			   {
			       $c = $c + sprintf($format,$row[$col]);
			   }
			   else
			   {
			       $c = $c + $row[$col];
			   }
		    }
	        return $formattype=='money' ? number_format($c,2,'.',',') : $c;
	    };
	   	//初始化模板
        $this->_smarty =& $this->_getView();
	    $this->_smarty->register_function('_count','_count');
		$smartyHelper =& new FLEA_View_SmartyHelper($this->_smarty);
		
		unset($smartyHelper);
	}
	
	//验证管理用户，如用户为空则跳转到登陆页
	function checkLogin()
	{		
	    if(!isset($this->_smarty))
		{
		   $this->initView();
		}
	    $rbac =& FLEA::getSingleton('FLEA_Rbac');
        $user = $rbac->getUser();
	  	if(!$user)
		{
			redirect(url('login','index'));
        }
		else
		{
		    $this->_smarty->assign('SE',$user);
		}
	}
	
	function u2gbk($string)
	{
    	return iconv("utf-8", "gb2312",$string);
    }
    //* 根据数据表的元数据返回一个数组，这个数组包含所有需要初始化的数据，可以用于界面显示
    //* @param array $meta
    //* @return array
    function prepareData(& $meta)
	{
        $data = array();
        foreach ($meta as $m)
		{
            if (isset($_POST[$m['name']])) 
			{
                $data[$m['name']] = $_POST[$m['name']];
            } 
			else 
			{
                if (isset($m['defaultValue'])) 
				{
                    $data[$m['name']] = $m['defaultValue'];
                } 
				else 
				{
                    $data[$m['name']] = null;
                }
            }
        }
        return $data;
    }

    // * 返回用 _setBack() 设置的 URL
    function goBack() 
	{
        $url = $this->_getBack();
        unset($_SESSION['BACKURL']);
        redirect($url);
    }


    // * 设置返回点 URL，稍后可以用 _goBack() 返回
    function setBack() 
	{
        $_SESSION['BACKURL'] = encode_url_args($_GET);
    }

    //* 获取返回点 URL
    //* @return string
    function getBack() 
	{
        if (isset($_SESSION['BACKURL'])) 
		{
            $url = $this->rawurl($_SESSION['BACKURL']);
        } else 
		{
            $url = $this->_url();
        }
        return $url;
    }

    //* 直接提供查询字符串，生成 URL 地址
    //* @param string $queryString
    //* @return string
    function rawUrl($queryString)
	{
    	if (substr($queryString, 0, 1) == '?')
		{
    		$queryString = substr($queryString, 1);
    	}
    	return $_SERVER['SCRIPT_NAME'] . '?' . $queryString;
    }
	
	//*{"statusCode":"200", "message":"操作成功", "navTabId":"navNewsLi", "forwardUrl":"", "callbackType":"closeCurrent"}
    //* {"statusCode":"300", "message":"操作失败"}
    //* {"statusCode":"301", "message":"会话超时"}
	function writeAjax($statusCode,$message,$navTabId,$callbackType,$forwardUrl)
    {
        echo ('{"statusCode":"'.$statusCode.'", "message":"'.$message.'", "navTabId":"'.$navTabId.'", "forwardUrl":"'.$forwardUrl.'", "callbackType":"'.$callbackType.'"}');  
    }
	

}
