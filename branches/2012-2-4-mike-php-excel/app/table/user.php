<?php
/////////////////////////////////////////////////////////////////////////////
// ���������Ķ���
FLEA::loadClass('FLEA_Db_TableDataGateway');

class table_user extends FLEA_Db_TableDataGateway
{
    //$tableName ��������ָ��������һ�����ݱ�
    var $tableName = 'srep_user';
    // $primaryKey ����ָ��Ҫ���������ݱ�������ֶ���
    var $primaryKey = 'UserID';
}
