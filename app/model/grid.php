<?php
/////////////////////////////////////////////////////////////////////////////
// 载入基础类的定义

FLEA::loadClass('FLEA_Db_TableDataGateway');

class model_grid extends FLEA_Db_TableDataGateway
{
    //$tableName 属性用于指定操作哪一个数据表
    var $tableName = 'srep_grid';
    // $primaryKey 属性指定要操作的数据表的主键字段名
    var $primaryKey = 'ID';
}