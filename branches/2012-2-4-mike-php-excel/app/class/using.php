<?php

//过滤非法值
class class_using
{

 //构造函数
 function class_using()
 {
 }

 function usingPost($varSpecs) 
 {
	global $__USING_POST_CALLED;
	$__USING_POST_CALLED = true;
	return safeUsing('post', $varSpecs);
 }
 
  function usingCookie($varSpecs) 
 {
	return safeUsing('cookie', $varSpecs);
 }

  function safeUsing($method, $varSpecs)
 {
	global $CFG;
	$method = strtolower($method);
	switch($method)
	{
		case 'post':
			$request = &$_POST;
			break;
		case 'get':
			$request = &$_GET;
			break;
		case 'cookie':
			$request = &$_COOKIE;
			break;
		case 'request':
			$request = &$_REQUEST;
			break;
		default:
			$request = array();
	}
	if(is_string($varSpecs)) 
	{
		$varSpecStr = explode(',', $varSpecs);
		$varSpecs = array();
		foreach($varSpecStr as $varSpec) 
		{
			list($varName, $varType) = explode(':', $varSpec);
			$varName = trim($varName);
			$varType = trim($varType);
			if(empty($varName)) continue;
			$varSpecs[$varName] = $varType;
		}
		unset($varSpecStr);
	}
	/*foreach($request as $varName => $varValue) 
	{
		switch($varSpecs[$varName]) 
		{
			case 'string': case 'str': case 'text':
				$request[$varName] = htmlspecialchars(trim($request[$varName]), ENT_COMPAT, $CFG['siteEncoding']);
				break;
			case 'dec':
				if(!ctype_digit($request[$varName])) 
				{
					unset($request[$varName]);
				}
				break;
			case 'hex':
				if(!ctype_xdigit($request[$varName]))
				{
					unset($request[$varName]);
				}
				break;
			case 'int':
				if(!ctype_digit($request[$varName]) && !ctype_xdigit($request[$varName])) 
				{
					unset($request[$varName]);
				}
				break;
			case 'number': case 'num':
				if(!is_numeric($request[$varName])) 
				{
					unset($request[$varName]);
				}
			case 'email': case 'eml':
				if(!is_email($request[$varName]))
				{
					unset($request[$varName]);
				}
				break;
			case 'cellphone': case 'mobile': case 'mbl':
				if(!is_cellphone($request[$varName])) 
				{
					unset($request[$varName]);
				}
				break;
			case 'date': case 'dat':
				if(!preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $request[$varName], $dt) && checkdate($dt[2], $dt[3], $dt[1])) 
				{
					unset($request[$varName]);
				}
				break;
			case 'unsafe':
				break;
			default:
				user_error('deleted $_POST[\''.$varName.'\']', E_USER_NOTICE);
				unset($request[$varName]);
		}
	}
         */
	return $request;
  }
}
?>
