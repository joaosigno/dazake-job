<?php
/////////////////////////////////////////////////////////////////////////////
// FleaPHP Framework
//
// Copyright (c) 2005 - 2008 QeeYuan China Inc. (http://www.qeeyuan.com)
//
// ���Э�飬��鿴Դ�����и����� LICENSE.txt �ļ���
// ���߷��� http://www.fleaphp.org/ �����ϸ��Ϣ��
/////////////////////////////////////////////////////////////////////////////

/**
 * �������п������ķ��ʿ��Ʊ�
 *
 * @copyright Copyright (c) 2005 - 2008 QeeYuan China Inc. (http://www.qeeyuan.com)
 * @author ��Դ�Ƽ� (www.qeeyuan.com)
 * @package Example
 * @subpackage SHOP
 * @version $Id: DefaultACT.php 972 2007-10-09 20:56:54Z qeeyuan $
 */

return array
(
    //login ������
    'login' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//index ������
    'index' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//ajax������
    'ajax' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//form������
    'form' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//user ������
    'user' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//salesreport������
    'salesreport' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//kcreport������
    'kcreport' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//jsreport������
    'jsreport' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//excel������
    'excel' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//kcexcel������
    'kcexcel' => array
	(
        'allow' => RBAC_EVERYONE,
    ),
	
	//jsexcel������
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
