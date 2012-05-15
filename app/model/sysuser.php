<?php
/////////////////////////////////////////////////////////////////////////////
//  定义Model_SysUser模型

FLEA::loadClass('FLEA_Rbac_UsersManager');

// Model_SysUser 封装了对系统用户信息的操作，同时还负责取出用户的角色信息

class model_sysuser extends FLEA_Rbac_UsersManager
{
   // 保存用户信息的数据表名称

    var $tableName     = 'srep_user';
    var $primaryKey    = 'UserID';
    var $usernameField = 'Username';
	var $emailField    = 'Email';
	var $encodeMethod = PWD_CLEARTEXT;//明文

}
