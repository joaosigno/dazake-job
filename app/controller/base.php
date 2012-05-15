<?php
/////////////////////////////////////////////////////////////////////////////
/*
 * Controller_Base �ǿ������Ļ��࣬�ṩһЩ���������ķ���
 */
////////////////////////////////////////////////////////////////////////////
class controller_base extends FLEA_Controller_Action
{
	var $_smarty;
    //*���캯��
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
	   	//��ʼ��ģ��
        $this->_smarty =& $this->_getView();
	    $this->_smarty->register_function('_count','_count');
		$smartyHelper =& new FLEA_View_SmartyHelper($this->_smarty);
		
		unset($smartyHelper);
	}
	
	//��֤�����û������û�Ϊ������ת����½ҳ
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
    //* �������ݱ��Ԫ���ݷ���һ�����飬����������������Ҫ��ʼ�������ݣ��������ڽ�����ʾ
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

    // * ������ _setBack() ���õ� URL
    function goBack() 
	{
        $url = $this->_getBack();
        unset($_SESSION['BACKURL']);
        redirect($url);
    }


    // * ���÷��ص� URL���Ժ������ _goBack() ����
    function setBack() 
	{
        $_SESSION['BACKURL'] = encode_url_args($_GET);
    }

    //* ��ȡ���ص� URL
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

    //* ֱ���ṩ��ѯ�ַ��������� URL ��ַ
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
	
	//*{"statusCode":"200", "message":"�����ɹ�", "navTabId":"navNewsLi", "forwardUrl":"", "callbackType":"closeCurrent"}
    //* {"statusCode":"300", "message":"����ʧ��"}
    //* {"statusCode":"301", "message":"�Ự��ʱ"}
	function writeAjax($statusCode,$message,$navTabId,$callbackType,$forwardUrl)
    {
        echo ('{"statusCode":"'.$statusCode.'", "message":"'.$message.'", "navTabId":"'.$navTabId.'", "forwardUrl":"'.$forwardUrl.'", "callbackType":"'.$callbackType.'"}');  
    }
	

}
