<?php
/////////////////////////////////////////////////////////////////////////////
// ���������Ķ���
FLEA::loadClass('FLEA_Db_TableDataGateway');

class model_salesdetail extends FLEA_Db_TableDataGateway
{
    //$tableName ��������ָ��������һ�����ݱ�
    var $tableName = 'salesdetail';
    // $primaryKey ����ָ��Ҫ���������ݱ�������ֶ���
    var $primaryKey = 'flistentryid';
}
