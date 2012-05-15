<?php
/////////////////////////////////////////////////////////////////////////////
// FleaPHP Framework
//
// Copyright (c) 2005 - 2008 QeeYuan China Inc. (http://www.qeeyuan.com)
//
// 许可协议，请查看源代码中附带的 LICENSE.txt 文件，
// 或者访问 http://www.fleaphp.org/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * 定义所有控制器的访问控制表
 *
 * @copyright Copyright (c) 2005 - 2008 QeeYuan China Inc. (http://www.qeeyuan.com)
 * @author 起源科技 (www.qeeyuan.com)
 * @package Example
 * @subpackage SHOP
 * @version $Id: DefaultACT.php 972 2007-10-09 20:56:54Z qeeyuan $
 */

return array
(
    //login 控制器
    'login' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//index 控制器
    'index' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//ajax控制器
    'ajax' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//form控制器
    'form' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//user 控制器
    'user' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//salesreport控制器
    'salesreport' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//kcreport控制器
    'kcreport' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//jsreport控制器
    'jsreport' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//excel控制器
    'excel' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//kcexcel控制器
    'kcexcel' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//jsexcel控制器
    'jsexcel' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//reportmanage
	'reportmanage' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
);
