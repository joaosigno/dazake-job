<?php
/////////////////////////////////////////////////////////////////////////////
// ���������Ķ���

FLEA::loadClass('FLEA_Db_TableDataGateway');

class model_grid extends FLEA_Db_TableDataGateway
{
    //$tableName ��������ָ��������һ�����ݱ�
    var $tableName = 'srep_grid';
    // $primaryKey ����ָ��Ҫ���������ݱ�������ֶ���
    var $primaryKey = 'ID';
}