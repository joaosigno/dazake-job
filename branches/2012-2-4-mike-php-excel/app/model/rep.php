<?php
/////////////////////////////////////////////////////////////////////////////
// ���������Ķ���

FLEA::loadClass('FLEA_Db_TableDataGateway');

class model_rep extends FLEA_Db_TableDataGateway
{
    //$tableName ��������ָ��������һ�����ݱ�
    var $tableName = 'v_delivery';
    // $primaryKey ����ָ��Ҫ���������ݱ�������ֶ���
    var $primaryKey = 'ID';
}