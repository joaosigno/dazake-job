<?php
/**
 * 定义 FLEA_Db_Driver_Mssql 驱动
 *
 * @author IceLoad
 * @version Mssql.php 2007-06-14
  */
 
//star
//问号作为参数占位符
define('DBO_PARAM_QM',          '?');
//冒号开始的命名参数
define('DBO_PARAM_CL_NAMED',    ':');
//$符号开始的序列
define('DBO_PARAM_DL_SEQUENCE', '$');
// @开始的命名参数
define('DBO_PARAM_AT_NAMED',    '@');

class FLEA_Db_Driver_Mssql
{
	//star
    var $PARAM_STYLE = DBO_PARAM_QM;
	
  /**
     * 用于 genSeq()、dropSeq() 和 nextId() 的 SQL 查询语句
     */
    var $NEXT_ID_SQL    = "UPDATE %s WITH (TABLOCK,HOLDLOCK) SET id = id + 1";
    var $CREATE_SEQ_SQL = "CREATE TABLE %s (id float(53))";
    var $INIT_SEQ_SQL   = "INSERT INTO %s WITH (TABLOCK,HOLDLOCK) VALUES (%s)";
    var $DROP_SEQ_SQL   = "DROP TABLE %s";

  /**
     * 用于描绘 true、false 和 null 的数据库值
     */
    var $TRUE_VALUE  = 1;
    var $FALSE_VALUE = 0;
    var $NULL_VALUE = 'NULL';

    /**
     * 用于获取元数据的 SQL 查询语句
     */
    var $META_COLUMNS_SQL = "SELECT a.COLUMN_NAME AS Field
			,(CASE WHEN CHARACTER_MAXIMUM_LENGTH IS NULL THEN DATA_TYPE + '(' + CONVERT(VARCHAR,NUMERIC_PRECISION) + ')' 
			ELSE DATA_TYPE + '(' + CONVERT(VARCHAR,CHARACTER_MAXIMUM_LENGTH) + ')' END) AS DataType
			,IS_NULLABLE AS Nullable
			,CONSTRAINT_TYPE AS PrimaryKey
			,COLUMN_DEFAULT AS DefaultValue
			,(CASE WHEN COLUMNPROPERTY(OBJECT_ID('%s'),a.COLUMN_NAME,'IsIdentity')=1 THEN 'auto_increment' ELSE '' END) AS Extra 
		FROM INFORMATION_SCHEMA.COLUMNS AS a LEFT JOIN (INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS b
			INNER JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS c ON b.CONSTRAINT_NAME=c.CONSTRAINT_NAME  AND b.TABLE_NAME=c.TABLE_NAME) 
			ON a.COLUMN_NAME=b.COLUMN_NAME AND a.TABLE_NAME=b.TABLE_NAME
		WHERE  a.TABLE_NAME='%s'";

    /**
     * 数据库连接信息
     *
     * @var array
     */
    var $dsn = null;

    /**
     * 数据库连接句柄
     *
     * @var resource
     */
    var $conn = null;

    /**
     * 所有 SQL 查询的日志
     *
     * @var array
     */
    var $log = array();

    /**
     * 指示是否记录 SQL 语句（部署模式时该设置默认为 false）
     *
     * @var boolean
     */
    var $enableLog = false;

    /**
     * 最后一次数据库操作的错误信息
     *
     * @var mixed
     */
    var $lasterr = null;

    /**
     * 最后一次数据库操作的错误代码
     *
     * @var mixed
     */
    var $lasterrcode = null;

    /**
     * 最近一次插入操作或者 nextId() 操作返回的插入 ID
     *
     * @var mixed
     */
    var $_insertId = null;

    /**
     * 指示事务启动次数
     *
     * @var int
     */
    var $_transCount = 0;

    /**
     * 指示事务是否提交
     *
     * @var boolean
     */
    var $_transCommit = true;

    /**
     * 构造函数
     *
     * @param array $dsn
     */
    function FLEA_Db_Driver_Mssql($dsn = false)
    {
        $tmp = (array)$dsn;
        unset($tmp['password']);
        $this->dsn = $dsn;
        $this->enableLog = !defined('DEPLOY_MODE') || DEPLOY_MODE != true;
        if (!function_exists('log_message')) {
            $this->enableLog = false;
        }
    }

    /**
     * 连接数据库
     *
     * @param array $dsn
     *
     * @return boolean
     */
    function connect($dsn = false)
    {
        $this->lasterr = null;
        $this->lasterrcode = null;

        if ($this->conn && $dsn == false) { return true; }
        if (!$dsn) {
            $dsn = $this->dsn;
        } else {
            $this->dsn = $dsn;
        }
        if (isset($dsn['port']) && $dsn['port'] != '') {
            $host = $dsn['host'] . ':' . $dsn['port'];
        } else {
            $host = $dsn['host'];
        }
        if (!isset($dsn['login'])) { $dsn['login'] = ''; }
        if (!isset($dsn['password'])) { $dsn['password'] = ''; }
		$this->conn = mssql_connect($host, $dsn['login'], $dsn['password']);

        if (!$this->conn) {
            FLEA::loadClass('FLEA_Db_Exception_SqlQuery');
            __THROW(new FLEA_Db_Exception_SqlQuery("mssql_connect('{$host}', '{$dsn['login']}') failed!", $this->mssql_error(), $this->mssql_errno()));
            return false;
        }

        if (!mssql_select_db($dsn['database'], $this->conn)) {
            FLEA::loadClass('FLEA_Db_Exception_SqlQuery');
            __THROW(new FLEA_Db_Exception_SqlQuery("SELECT DATABASE: '{$dsn['database']}' FAILED!", $this->mssql_error($this->conn), $this->mssql_errno($this->conn)));
            return false;
        }
/*
        $version = $this->getOne('SELECT @@VERSION');
        if (isset($dsn['charset']) && $dsn['charset'] != '') {
            $charset = $dsn['charset'];
        } else {
            $charset = FLEA::getAppInf('databaseCharset');
        }
        if ($version >= '4.1' && $charset != '') {
            if (!$this->execute("SET NAMES '" . $charset . "'")) { return false; }
        }
*/
        return true;
    }

    /**
     * 关闭数据库连接
     */
    function close()
    {
        if ($this->conn) {
            mssql_close($this->conn);
        }
        $this->conn = null;
        $this->lasterr = null;
        $this->lasterrcode = null;
        $this->_insertId = null;
        $this->_transCount = 0;
        $this->_transCommit = true;
    }

    /**
     * 执行一个查询，返回一个 resource 或者 boolean 值
     *
     * @param string $sql
     * @param array $inputarr
     * @param boolean $throw 指示查询出错时是否抛出异常
     *
     * @return resource|boolean
     */
    function execute($sql, $inputarr = null, $throw = true)
    {
        if (is_array($inputarr)) {
            $sql = $this->_prepareSql($sql, $inputarr);
        }
        if ($this->enableLog) {
            $this->log[] = $sql;
            log_message("sql:\n{$sql}", 'debug');
        }

        $result = @mssql_query($sql, $this->conn);
        if ($result !== false) {
            $this->lasterr = null;
            $this->lasterrcode = null;
            return $result;
        }
        $this->lasterr = $this->mssql_error($this->conn);
        $this->lasterrcode = $this->mssql_errno($this->conn);
        if (!$throw) { return false; }

        FLEA::loadClass('FLEA_Db_Exception_SqlQuery');
        __THROW(new FLEA_Db_Exception_SqlQuery($sql, $this->lasterr, $this->lasterrcode));
        return false;
    }

    /**
     * 转义字符串
     *
     * @param string $value
     *
     * @return mixed
     */
    function qstr($value)
    {
        if (is_bool($value)) { return $value ? $this->TRUE_VALUE : $this->FALSE_VALUE; }
        if (is_null($value)) { return $this->NULL_VALUE; }
        return "'" . $this->mssql_real_escape_string($value, $this->conn) . "'";
    }

    /**
     * 将数据表名字转换为完全限定名
     *
     * @param string $tableName
     *
     * @return string
     */
    function qtable($tableName)
    {
        if (substr($tableName, 0, 1) == '[') { return $tableName; }
        return $tableName ;
    }
  //STAR
    /**
     * 将字段名转换为完全限定名，避免因为字段名和数据库关键词相同导致的错误
     *
     * @param string $fieldName
     * @param string $tableName
     *
     * @return string
     */
    function qfield($fieldName, $tableName = null)
    {
        $pos = strpos($fieldName, '.');
        if ($pos !== false) {
            $tableName = substr($fieldName, 0, $pos);
            $fieldName = substr($fieldName, $pos + 1);
        }
        if ($tableName != '') {
            if ($fieldName != '*') {
                return "[{$tableName}].[{$fieldName}]";
            } else {
                return "[{$tableName}].*";
            }
        } else {
            if ($fieldName != '*') {
                return "[{$fieldName}]";
            } else {
                return "*";
            }
        }
    }

    /**
     * 一次性将多个字段名转换为完全限定名
     *
     * @param string|array $fields
     * @param string $tableName
     *
     * @return string
     */
    function qfields($fields, $tableName = null)
    {
        if (!is_array($fields)) {
            $fields = explode(',', $fields);
        }
        $return = array();
        foreach ($fields as $fieldName) {
            $fieldName = trim($fieldName);
            if ($fieldName == '') { continue; }
            $pos = strpos($fieldName, '.');
            if ($pos !== false) {
                $tableName = substr($fieldName, 0, $pos);
                $fieldName = substr($fieldName, $pos + 1);
            }
            if ($tableName != '') {
                if ($fieldName != '*') {
                    $return[] = "[{$tableName}].[{$fieldName}]";
                } else {
                    $return[] = "[{$tableName}].*";
                }
            } else {
                if ($fieldName != '*') {
                    $return[] = "[{$fieldName}]";
                } else {
                    $return[] = '*';
                }
            }
        }
        return implode(', ', $return);
    }

    /**
     * 为数据表产生下一个序列值
     *
     * @param string $seqName
     * @param string $startValue
     *
     * @return int
     */
    function nextId($seqName = 'sdboseq', $startValue = 1)
    {
		$this->execute('BEGIN TRANSACTION ' . $seqName);
		$ok = $this->execute(sprintf($this->NEXT_ID_SQL, $seqName), null, false);
		if ($ok === false) {
			$this->execute(sprintf($this->CREATE_SEQ_SQL, $seqName));
			$ok = $this->execute(sprintf($this->INIT_SEQ_SQL, $seqName, $startValue));
			if (!$ok) {
				$this->execute('ROLLBACK TRANSACTION ' . $seqName);
				return false;
			}
			$this->execute('COMMIT TRANSACTION ' . $seqName);
			return $startValue;
		}
		$num = $this->query_scalar_function('SELECT id FROM ' . $seqName);
		$this->execute('COMMIT TRANSACTION ' . $seqName); 
		return $num;
    }

    /**
     * 创建一个新的序列，成功返回 true，失败返回 false
     *
     * @param string $seqName
     * @param int $startValue
     *
     * @return boolean
     */
    function createSeq($seqName = 'sdboseq', $startValue = 1)
    {
		$this->execute('BEGIN TRANSACTION ' . $seqName);
		$this->execute(sprintf($this->CREATE_SEQ_SQL, $seqName));
		$ok = $this->execute(sprintf($this->INIT_SEQ_SQL, $seqName, $startValue - 1));
		if (!$ok) {
			$this->execute('ROLLBACK TRANSACTION ' . $seqName);
			return false;
		}
		$this->execute('COMMIT TRANSACTION ' . $seqName);
		return true;
    }

    /**
     * 删除一个序列
     *
     * 具体的实现与数据库系统有关。
     *
     * @param string $seqName
     */
    function dropSeq($seqName = 'sdboseq')
    {
        return $this->execute(sprintf($this->DROP_SEQ_SQL, $seqName));
    }

    /**
     * 获取自增字段的最后一个值
     *
     * @return mixed
     */
    function insertId()
    {
        return $this->mssql_insert_id($this->conn);
    }

    /**
     * 返回最近一次数据库操作受到影响的记录数
     *
     * @return int
     */
	function numRows($res)
	{
		return mssql_num_rows($res);
	}
	 function affectedRows()
    {
        return mssql_rows_affected($this->conn);
    }

    /**
     * 从记录集中返回一行数据
     *
     * @param resouce $res
     *
     * @return array
     */
    function fetchRow($res)
    {
        return mssql_fetch_row($res);
    }

    /**
     * 从记录集中返回一行数据，字段名作为键名
     *
     * @param resouce $res
     *
     * @return array
     */
    function fetchAssoc($res)
    {
        return mssql_fetch_assoc($res);
    }

    /**
     * 释放查询句柄
     *
     * @param resource $res
     *
     * @return boolean
     */
    function freeRes($res)
    {
        return mssql_free_result($res);
    }

    /**
     * 进行限定记录集的查询
     *
     * @param string $sql
     * @param int $length
     * @param int $offset
     *
     * @return resource
     */
    function selectLimit($sql, $length = null, $offset = null,$id = null)
    {
	    $IDENTITYCOL = isset($id) ? $id : 'IDENTITYCOL';
		if(is_numeric($length)){
			$intPageSize = intval($length);
			if($intPageSize < 0){$intPageSize = 0;}
		}else{
			$intPageSize = 0;
		}
		if(is_numeric($offset)){
			$intStartPosition = intval($offset);
			if($intStartPosition < 0){$intStartPosition = 0;}
		}else{
			$intStartPosition = 0;
		}
		$strSQL = $sql;
		$strPattern = '/^\s*(SELECT\s+(ALL|DISTINCT)?(\s+TOP\s+\d+)?(.+))(\s+FROM\s+.+)';
		if(strripos($strSQL, 'WHERE')){
			$strPattern .= '(\s+WHERE\s+.+)';
		}
		if(strripos($strSQL, 'GROUP BY')){
			$strPattern .= '(\s+GROUP BY\s+.+)';
		}
		if(strripos($strSQL, 'HAVING')){
			$strPattern .= '(\s+HAVING\s+.+)';
		}
		if(strripos($strSQL, 'ORDER BY')){
			$strPattern .= '(\s+ORDER BY\s+.+)';
		}
		$strPattern .= '$/i';
		$arrMatches = array();
		if(preg_match($strPattern, $strSQL, $arrMatches)){
			$j = count($arrMatches);
			for($i = 0; $i < $j; $i ++){
				$arrMatches[$i] = trim($arrMatches[$i]);
			}
			if(empty($arrMatches[3]) && $j > 5){
				$strLimitSql = 'SELECT ' . $arrMatches[2] . ' TOP ' . $intPageSize . ' ' . $arrMatches[4];
				$strLimitSql .= ' ' . $arrMatches[5];
				$strAlias = '';
				if(strpos($arrMatches[5], ',')){
					$strAlias = substr($arrMatches[5], 0, strpos($arrMatches[5], ','));
				}elseif(stristr($arrMatches[5], " JOIN ")){
					$strAlias = stristr($arrMatches[5], " JOIN ");
					$strAlias = substr($arrMatches[5], 0, strpos($arrMatches[5], $strAlias));
				}
				if(! empty($strAlias)){
					$strAlias = trim(substr($strAlias, 4));
					$arrAlias = split(' ', $strAlias);
					$strAlias = $arrAlias[0];
					if(strtoupper($arrAlias[1]) == 'AS'){
						$strAlias = $arrAlias[2];
					}elseif(! in_array(strtoupper($arrAlias[1]), array('INNER','LEFT','JOIN','RIGHT','FULL'))){
						$strAlias = $arrAlias[1];
					}
					//$strAlias = trim(substr($strAlias, strrpos($strAlias, ' ')));
					if(! empty($strAlias))$strAlias .= '.';
				}
				if($j > 6){
					if(strtoupper(substr($arrMatches[6], 0, 5)) == 'WHERE'){
						$strLimitSql .= ' WHERE (' . substr($arrMatches[6], 5) . ') AND ' . $strAlias . $IDENTITYCOL.' NOT IN (';
						$strLimitSql .= 'SELECT ' . $arrMatches[2] . ' TOP ' . $intStartPosition . ' ' . $strAlias . $IDENTITYCOL.' ' . $arrMatches[5];
						for($i = 6; $i < $j; $i ++){
							$strLimitSql .= ' ' . $arrMatches[$i];
						}
						$strLimitSql .= ')';
						for($i = 7; $i < $j; $i ++){
							$strLimitSql .= ' ' . $arrMatches[$i];
						}
					}else{
						$strLimitSql .= ' WHERE ' . $strAlias . $IDENTITYCOL.' NOT IN (';
						$strLimitSql .= 'SELECT ' . $arrMatches[2] . ' TOP ' . $intStartPosition . ' ' . $strAlias . $IDENTITYCOL.' ' . $arrMatches[5];
						for($i = 6; $i < $j; $i ++){
							$strLimitSql .= ' ' . $arrMatches[$i];
						}
						$strLimitSql .= ')';
						for($i = 6; $i < $j; $i ++){
							$strLimitSql .= ' ' . $arrMatches[$i];
						}
					}
				}else{
					$strLimitSql .= ' WHERE ' . $strAlias . $IDENTITYCOL.' NOT IN (';
					$strLimitSql .= 'SELECT ' . $arrMatches[2] . ' TOP ' . $intStartPosition . ' ' . $strAlias . $IDENTITYCOL.' ' . $arrMatches[5];
					$strLimitSql .= ')';
				}
				return $this->execute($strLimitSql);
			}
			return false;
		}
		return false;
	}

    /**
     * 执行一个查询，返回查询结果记录集
     *
     * @param string|resource $sql
     *
     * @return array
     */
    function & getAll($sql)
    {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->execute($sql);
        }
        $data = array();
        while ($row = mssql_fetch_assoc($res)) {
            $data[] = $row;
        }
        mssql_free_result($res);
        return $data;
    }

    /**
     * 执行一个查询，返回分组后的查询结果记录集
     *
     * $groupBy 参数如果为字符串或整数，表示结果集根据 $groupBy 参数指定的字段进行分组。
     * 如果 $groupBy 参数为 true，则表示根据每行记录的第一个字段进行分组。
     *
     * @param string|resource $sql
     * @param string|int|boolean $groupBy
     *
     * @return array
     */
    function & getAllGroupBy($sql, $groupBy)
    {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->execute($sql);
        }
        $data = array();

        $row = mssql_fetch_assoc($res);
        if ($row != false) {
            if ($groupBy === true) {
                $groupBy = key($row);
            }
            do {
                $rkv = $row[$groupBy];
                unset($row[$groupBy]);
                $data[$rkv][] = $row;
            } while ($row = mssql_fetch_assoc($res));
        }

        mssql_free_result($res);

        return $data;
    }

    /**
     * 执行一个查询，返回查询结果记录集、指定字段的值集合以及以该字段值分组后的记录集
     *
     * @param string|resource $sql
     * @param string $field
     * @param array $fieldValues
     * @param array $reference
     *
     * @return array
     */
    function getAllWithFieldRefs($sql, $field, & $fieldValues, & $reference)
    {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->execute($sql);
        }

        $fieldValues = array();
        $reference = array();
        $offset = 0;
        $data = array();
        while ($row = mssql_fetch_assoc($res)) {
            $fieldValue = $row[$field];
            unset($row[$field]);
            $data[$offset] = $row;
            $fieldValues[$offset] = $fieldValue;
            $reference[$fieldValue] =& $data[$offset];
            $offset++;
        }
        mssql_free_result($res);
        return $data;
    }

    /**
     * 执行一个查询，并将数据按照指定字段分组后与 $assocRowset 记录集组装在一起
     *
     * @param string|resource $sql
     * @param array $assocRowset
     * @param string $mappingName
     * @param boolean $oneToOne
     * @param string $refKeyName
     * @param mixed $limit
     */
    function assemble($sql, & $assocRowset, $mappingName, $oneToOne, $refKeyName, $limit = null)
    {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            if ($limit !== null) {
                if (is_array($limit)) {
                    list($length, $offset) = $limit;
                } else {
                    $length = $limit;
                    $offset = 0;
                }
                $res = $this->selectLimit($sql, $length, $offset);
            } else {
                $res = $this->execute($sql);
            }
        }

        if ($oneToOne) {
            // 一对一组装数据
            while ($row = mssql_fetch_assoc($res)) {
                $rkv = $row[$refKeyName];
                unset($row[$refKeyName]);
                $assocRowset[$rkv][$mappingName] = $row;
            }
        } else {
            // 一对多组装数据
            while ($row = mssql_fetch_assoc($res)) {
                $rkv = $row[$refKeyName];
                unset($row[$refKeyName]);
                $assocRowset[$rkv][$mappingName][] = $row;
            }
        }

        mssql_free_result($res);
    }

    /**
     * 执行查询，返回第一条记录的第一个字段
     *
     * @param string|resource $sql
     *
     * @return mixed
     */
    function getOne($sql)
    {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->execute($sql);
        }
        $row = mssql_fetch_row($res);
        mssql_free_result($res);
        return isset($row[0]) ? $row[0] : null;
    }

    /**
     * 执行查询，返回第一条记录
     *
     * @param string|resource $sql
     *
     * @return mixed
     */
    function & getRow($sql)
    {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->execute($sql);
        }
        $row = mssql_fetch_assoc($res);
        mssql_free_result($res);
        return $row;
    }

    /**
     * 执行查询，返回结果集的指定列
     *
     * @param string|resource $sql
     * @param int $col 要返回的列，0 为第一列
     *
     * @return mixed
     */
    function & getCol($sql, $col = 0)
    {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->execute($sql);
        }
        $data = array();
        while ($row = mssql_fetch_row($res)) {
            $data[] = $row[$col];
        }
        mssql_free_result($res);
        return $data;
    }

    /**
     * 返回指定表（或者视图）的元数据
     *
     * 部分代码参考 ADOdb 实现。
     *
     * 每个字段包含下列属性：
     *
     * name:            字段名
     * scale:           小数位数
     * type:            字段类型
     * simpleType:      简单字段类型（与数据库无关）
     * maxLength:       最大长度
     * notNull:         是否不允许保存 NULL 值
     * primaryKey:      是否是主键
     * autoIncrement:   是否是自动增量字段
     * binary:          是否是二进制数据
     * unsigned:        是否是无符号数值
     * hasDefault:      是否有默认值
     * defaultValue:    默认值
     *
     * @param string $table
     *
     * @return array
     */
    function & metaColumns($table)
    {
        /**
         *  C 长度小于等于 250 的字符串
         *  X 长度大于 250 的字符串
         *  B 二进制数据
         *  N 数值或者浮点数
         *  D 日期
         *  T TimeStamp
         *  L 逻辑布尔值
         *  I 整数
         *  R 自动增量或计数器
         */
        static $typeMap = array(
            'BIT'           => 'I',
			'BIT()'           => 'I',
            'TINYINT'       => 'I',
            'BOOL'          => 'L',
            'BOOLEAN'       => 'L',
            'SMALLINT'      => 'I',
            'MEDIUMINT'     => 'I',
            'INT'           => 'I',
            'INTEGER'       => 'I',
            'BIGINT'        => 'I',
            'FLOAT'         => 'N',
            'DOUBLE'        => 'N',
            'DOUBLEPRECISION' => 'N',
			'REAL'          => 'N',
			'NUMERIC'       => 'N',
            'DECIMAL'       => 'N',
            'DEC'           => 'N',
			'MONEY'         => 'N',
			'SMALLMONEY'    => 'N',
            'DATE'          => 'D',
			'DATE()'        => 'D',
			'DATETIME()'    => 'T',
            'DATETIME'      => 'T',
			'SMALLDATETIME' => 'T',
            'TIMESTAMP'     => 'T',
            'TIME'          => 'T',
            'YEAR'          => 'I',

            'CHAR'          => 'C',
            'NCHAR'         => 'C',
            'VARCHAR'       => 'C',
            'NVARCHAR'      => 'C',
            'BINARY'        => 'B',
            'VARBINARY'     => 'B',
            'TINYBLOB'      => 'X',
            'TINYTEXT'      => 'X',
            'BLOB'          => 'X',
            'TEXT'          => 'X',
			'NTEXT'         => 'X',
            'MEDIUMBLOB'    => 'X',
            'MEDIUMTEXT'    => 'X',
            'LONGBLOB'      => 'X',
            'LONGTEXT'      => 'X',
            'ENUM'          => 'C',
            'SET'           => 'C',
        );

        //$table = $this->qtable($table);echo sprintf($this->META_COLUMNS_SQL, $table, $table);exit;
        $rs = $this->execute(sprintf($this->META_COLUMNS_SQL, $table, $table));
        if (!$rs) { return false; }
        $retarr = array();
        while (($row = mssql_fetch_row($rs))) {
            $field = array();
            $field['name'] = $row[0];
            $type = $row[1];

            $field['scale'] = null;
            $queryArray = false;
            if (preg_match('/^(.+)\((\d+),(\d+)/', $type, $queryArray)) {
                $field['type'] = $queryArray[1];
                $field['maxLength'] = is_numeric($queryArray[2]) ? $queryArray[2] : -1;
                $field['scale'] = is_numeric($queryArray[3]) ? $queryArray[3] : -1;
            } elseif (preg_match('/^(.+)\((\d+)/', $type, $queryArray)) {
                $field['type'] = $queryArray[1];
                $field['maxLength'] = is_numeric($queryArray[2]) ? $queryArray[2] : -1;
            } elseif (preg_match('/^(enum)\((.*)\)$/i', $type, $queryArray)) {
                $field['type'] = $queryArray[1];
                $arr = explode(",",$queryArray[2]);
                $field['enums'] = $arr;
                $zlen = max(array_map("strlen",$arr)) - 2; // PHP >= 4.0.6
                $field['maxLength'] = ($zlen > 0) ? $zlen : 1;
            } else {
                $field['type'] = $type;
                $field['maxLength'] = -1;
            }
			
            $field['simpleType'] = $typeMap[strtoupper($field['type'])];
            if ($field['simpleType'] == 'C' && $field['maxLength'] > 255) {
                $field['simpleType'] = 'X';
            }
            $field['notNull'] = ($row[2] != 'YES');
			if (is_null($row[3])) { $row[3] = ''; }
            $field['primaryKey'] = ($row[3] == 'PRIMARY KEY');
            $field['autoIncrement'] = (strpos($row[5], 'auto_increment') !== false);
            if ($field['autoIncrement']) { $field['simpleType'] = 'R'; }
            $field['binary'] = (strpos($type,'blob') !== false);
            $field['unsigned'] = (strpos($type,'unsigned') !== false);

            if (!$field['binary']) {
                $d = is_null($row[4]) ? '' : $row[4];
				if ($d != '') {
					if (substr($d, 0, 1) == '(') {
						$d = substr($d, 1, strlen($d) - 2);
						if (substr($d, 0, 1) == "'") { $d = substr($d, 1, strlen($d) - 2); }
					}
				}
                if ($d != '') {
                    $field['hasDefault'] = true;
                    $field['defaultValue'] = $d;
                } else {
                    $field['hasDefault'] = false;
                }
            }
            $retarr[strtoupper($field['name'])] = $field;
        }
        mssql_free_result($rs);
        return $retarr;
    }

    /**
     * 返回数据库可以接受的日期格式
     *
     * @param int $timestamp
     */
    function dbTimeStamp($timestamp)
    {
        return date('Y-m-d H:i:s', $timestamp);
    }

    /**
     * 启动事务
     */
    function startTrans()
    {
    }

    /**
     * 完成事务，根据查询是否出错决定是提交事务还是回滚事务
     *
     * 如果 $commitOnNoErrors 参数为 true，当事务中所有查询都成功完成时，则提交事务，否则回滚事务
     * 如果 $commitOnNoErrors 参数为 false，则强制回滚事务
     *
     * @param $commitOnNoErrors 指示在没有错误时是否提交事务
     */
    function completeTrans($commitOnNoErrors = true)
    {
        return false;
    }

    /**
     * 强制指示在调用 completeTrans() 时回滚事务
     */
    function failTrans()
    {
        $this->_transCommit = false;
    }

    /**
     * 反复事务是否失败的状态
     */
    function hasFailedTrans()
    {
        return true;
    }

    /**
     * 根据 SQL 语句和提供的参数数组，生成最终的 SQL 语句
     *
     * @param string $sql
     * @param array $inputarr
     *
     * @return string
     */
    function _prepareSql($sql, & $inputarr)
    {
        $sqlarr = explode('?', $sql);
        $sql = '';
        $ix = 0;
        foreach ($inputarr as $v) {
            $sql .= $sqlarr[$ix];
            $typ = gettype($v);
            if ($typ == 'string') {
                $sql .= $this->qstr($v);
            } else if ($typ == 'double') {
                $sql .= $this->qstr(str_replace(',', '.', $v));
            } else if ($typ == 'boolean') {
                $sql .= $v ? $this->TRUE_VALUE : $this->FALSE_VALUE;
            } else if ($v === null) {
                $sql .= 'NULL';
            } else {
                $sql .= $v;
            }
            $ix += 1;
        }
        if (isset($sqlarr[$ix])) {
            $sql .= $sqlarr[$ix];
        }
        return $sql;
    }

    /**
     * 返回上一个 MsSQL 函数的错误号码
     *
     * @param resource link_identifier $conn
     *
     * @return int
     */
	function mssql_errno(&$conn = false)
	{
		$errorSQL = "SELECT @@ERROR";
		if (empty($conn)) {
			$num = $this->query_scalar_function($errorSQL);
		} else {
			$num = $this->query_scalar_function($errorSQL, $conn);
		}
		return $num;
	}

    /**
     * 返回上一个 MsSQL 函数的错误文本
     *
     * @param resource link_identifier $conn
     *
     * @return string
     */
	function mssql_error(&$conn = false)
	{
		return mssql_get_last_message();
	}

    /**
     * 取得上一步 INSERT 操作产生的 ID 
     *
     * @param resource link_identifier $conn
     *
     * @return int
     */
	function mssql_insert_id(&$conn = false)
	{
		$identitySQL = 'SELECT @@IDENTITY'; // 'SELECT SCOPE_IDENTITY'; 'SELECT IDENT_CURRENT(table_name)' # for mssql 2000
		if (empty($conn)) {
			$id = $this->query_scalar_function($identitySQL);
		} else {
			$id = $this->query_scalar_function($identitySQL, $conn);
		}
		return $id;
	}

	function mssql_real_escape_string($value, &$conn = false)
	{
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		$value = str_replace("'", "''", $value);
		return $value;
	}

	function query_scalar_function($sql, &$conn = false)
	{
		if (empty($conn)) {
			$rs = @mssql_query($sql, $this->conn);
		} else {
			$rs = @mssql_query($sql, $conn);
		}
		if (!$rs) return false;
		$arr = mssql_fetch_array($rs);
		mssql_free_result($rs);
		if (is_array($arr)) {
			return $arr[0];
		} else { 
			return -1;
		}
	}
	
	//star
    /**
     * 根据驱动的参数占位符样式，返回包含参数占位符及有效数据的数组
     *
     * @param array $inputarr
     * @param array $fields
     *
     * @return array
     */
    function getPlaceholder(& $inputarr, $fields = null)
    {
        $holders = array();
        $values = array();
        if (is_array($fields)) {
            $fields = array_change_key_case(array_flip($fields), CASE_LOWER);
            foreach (array_keys($inputarr) as $key) {
                if (!isset($fields[strtolower($key)])) { continue; }
                if ($this->PARAM_STYLE == DBO_PARAM_QM) {
                    $holders[] = $this->PARAM_STYLE;
                } else {
                    $holders[] = $this->PARAM_STYLE . $key;
                }
                $values[$key] =& $inputarr[$key];
            }
        } else {
            foreach (array_keys($inputarr) as $key) {
                if ($this->PARAM_STYLE == DBO_PARAM_QM) {
                    $holders[] = $this->PARAM_STYLE;
                } else {
                    $holders[] = $this->PARAM_STYLE . $key;
                }
                $values[$key] =& $inputarr[$key];
            }
        }
        return array($holders, $values);
    }
	
	//star
    /**
     * 根据驱动的参数占位符样式，返回包含参数及占位符字符串对、有效数据的数组
     *
     * @param array $inputarr
     * @param array $fields
     *
     * @return array
     */
    function getPlaceholderPair(& $inputarr, $fields = null)
    {
        $pairs = array();
        $values = array();
        if (is_array($fields)) {
            $fields = array_change_key_case(array_flip($fields), CASE_LOWER);
            foreach (array_keys($inputarr) as $key) {
                if (!isset($fields[strtolower($key)])) { continue; }
                $qkey = $this->qfield($key);
                if ($this->PARAM_STYLE == DBO_PARAM_QM) {
                    $pairs[] = "{$qkey}={$this->PARAM_STYLE}";
                } else {
                    $pairs[] = "{$qkey}={$this->PARAM_STYLE}{$key}";
                }
                $values[$key] =& $inputarr[$key];
            }
        } else {
            foreach (array_keys($inputarr) as $key) {
                $qkey = $this->qfield($key);
                if ($this->PARAM_STYLE == DBO_PARAM_QM) {
                    $pairs[] = "{$qkey}={$this->PARAM_STYLE}";
                } else {
                    $pairs[] = "{$qkey}={$this->PARAM_STYLE}{$key}";
                }
                $values[$key] =& $inputarr[$key];
            }
        }
        return array($pairs, $values);
    }
}

/**
 * 与 FLEA_Db_Driver_Mssql 的唯一区别在于 FLEA_Db_Driver_Mssqlt 支持事务功能
 *
 * 要求表的存储引擎为 InnoDB 或者 BDB。
 *
 * @package Core
 * @author 廖宇雷 dualface@gmail.com
 * @version 1.1
 */
class FLEA_Db_Driver_Mssqlt extends FLEA_Db_Driver_Mssql
{
    /**
     * 指示事务启动次数
     *
     * @var int
     */
    var $_transCount = 0;

    /**
     * 指示事务是否提交
     *
     * @var boolean
     */
    var $_transCommit = true;

    /**
     * 启动事务
     */
    function startTrans()
    {
        $this->_transCount += 1;
        if ($this->_transCount == 1) {
            $this->execute('BEGIN TRAN');
        }
    }

    /**
     * 完成事务，根据查询是否出错决定是提交事务还是回滚事务
     *
     * 如果 $commitOnNoErrors 参数为 true，当事务中所有查询都成功完成时，则提交事务，否则回滚事务
     * 如果 $commitOnNoErrors 参数为 false，则强制回滚事务
     *
     * @param $commitOnNoErrors 指示在没有错误时是否提交事务
     */
    function completeTrans($commitOnNoErrors = true)
    {
        if ($this->_transCount < 1) { return false; }
        if ($this->_transCount > 1) {
            $this->_transCount -= 1;
            return true;
        }
        $this->_transCount = 0;

        if ($this->_transCommit && $commitOnNoErrors) {
            $ret = $this->execute('COMMIT TRAN');
            return $ret;
        } else {
            $this->execute('ROLLBACK TRAN');
            return false;
        }
    }

    /**
     * 强制指示在调用 completeTrans() 时回滚事务
     */
    function failTrans()
    {
        $this->_transCommit = false;
    }

    /**
     * 反复事务是否失败的状态
     */
    function hasFailedTrans()
    {
        if ($this->_transCount > 0) {
            return $this->_transCommit === false;
        }
        return false;
    }
}
