<?php
/////////////////////////////////////////////////////////////////////////////
// 载入基础类的定义
FLEA::loadClass('FLEA_Db_TableDataGateway');

class table_user extends FLEA_Db_TableDataGateway
{
    //$tableName 属性用于指定操作哪一个数据表
    var $tableName = 'srep_user';
    // $primaryKey 属性指定要操作的数据表的主键字段名
    var $primaryKey = 'UserID';
}
