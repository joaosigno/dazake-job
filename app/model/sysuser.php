<?php
/////////////////////////////////////////////////////////////////////////////
//  ����Model_SysUserģ��

FLEA::loadClass('FLEA_Rbac_UsersManager');

// Model_SysUser ��װ�˶�ϵͳ�û���Ϣ�Ĳ�����ͬʱ������ȡ���û��Ľ�ɫ��Ϣ

class model_sysuser extends FLEA_Rbac_UsersManager
{
   // �����û���Ϣ�����ݱ�����

    var $tableName     = 'srep_user';
    var $primaryKey    = 'UserID';
    var $usernameField = 'Username';
	var $emailField    = 'Email';
	var $encodeMethod = PWD_CLEARTEXT;//����

}
