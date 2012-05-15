<?php
/**
 * 查询条件类
 *
 */
class class_conditions
{
	var $array=null;
	
	//构造函数
    function class_conditions()
    {
	
    }
	
	function getper($fieldtype)
    {
     	if ($fieldtype=='I')
		{
		    return '';
		}	
		elseif ($fieldtype=='D')
		{
		    return "'";
		}
		elseif ($fieldtype=='S')
		{
		    return "'";
		}
		else
		{
		    return '';
		}
    }
	
	/**
	* 设定like查询
	*
	* @param sting $value 匹配值
	* @param array $fields 匹配字段
	* @param sting $flag  or/and
	* @return  自身对象
	*/
	function like($value,$fields,$flag=' or ')
	{
		if(empty($value) || !$fields[0]) return $this;
		$this->array[]=implode(',',$fields)." like '%".$value."%' ";
		return $this;
	}
	
	/**
	 * 指定范围查询
	 *
	 * @param string $start 开始的取值
	 * @param string $end 结束的取值
	 * @param string $field 匹配字段
	 * @param int $flag 四种情况：1（><），2（>= <=），3（> <=），4（>= <）
	* @return  自身对象
	 */
	function between($start,$end,$field,$fieldtype,$flag=1)
	{
	    $per = $this->getper($fieldtype);
		$start_type		= (in_array($flag,array(1,3)))? '>' : '>=';
		$end_type		= (in_array($flag,array(1,4)))? '<' : '<=';
		if(!empty($start))	{	$this->array[]		= array($field,$per.$start.$per,$start_type);}
		if(!empty($end))	{	$this->array[]		= array($field,$per.$end.$per,$end_type);}
		return $this;
	}
	/**
	 * 正则指定字段
	 *
	 * @param string $expr 表达式
	 * @param string $field 匹配字段
	* @return  自身对象
	 */
	function regexp($expr,$field)
	{
		if(isset($expr))	{	$this->array[]		= array($field,"((^$expr,|,$expr$)|,$expr,)|^$expr$" ,'REGEXP');}
		return $this;
	}
	/**
	 * 大于（大于等于）查询
	 *
	 * @param string $start 开始的取值
	 * @param string $type 类型 >或者 >=
	 * @param string $field 匹配字段
	* @return  自身对象
	 */
	function greater($start,$field,$type='>')
	{
		if(empty($start))return $this;
		$this->array[]		= array($field,$start,$type);
		return $this;	
	}
	/**
	 * 小于（小于等于）查询
	 *
	 * @param string $start 开始的取值
	 * @param string $type 类型 <或者 <=
	 * @param string $field 匹配字段
	* @return  自身对象
	 */
	function smaller($start,$field,$type='<')
	{
		if(empty($start))return $this;
		$this->array[]		= array($field,$start,$type);
		return $this;	
	}
	/**
	 * 匹配相等查询
	 *
	 * @param sting $value 
	 * @param sting $field
	 * @param sting $flag or/and
	 * @return 自身对象
	 */
	function equal($value,$field,$fieldtype,$flag=' and ')
	{
	    $per = $this->getper($fieldtype);
		if ($value===0) 
		{
			$this->array[]		= array($field,$per.$value.$per,'=',$flag);
		}
		if(empty($value)) return $this;
		$this->array[]		= array($field,$per.$value.$per,'=',$flag);
		return $this;
	}
	/**
	 * 匹配不相等查询
	 *
	 * @param sting $value 
	 * @param sting $field
	 * @param sting $flag or/and
	 * @return 自身对象
	 */
	function nequal($value,$field,$flag=' and ')
	{
		if(!isset($value)) return $this;
		$this->array[]		= array($field,$value,'<>',$flag);
		return $this;
	}
	/**
	 * 匹配in查询 
	 *
	 * @param array $values 
	 * @param sting $field
	 * @param sting $flag or/and
	 * @return 自身对象
	 * 问题：没有办法用两个以上的in
	 */
	function in($values,$field)
	{
		if(empty($values)) return $this;
		$this->array['in()']		= array($field=>$values);
		return $this;
	}
	/**
	 * 匹配not in查询 
	 *
	 * @param array $values 
	 * @param sting $field
	 * @param sting $flag or/and
	 * @return 自身对象
	 */
	function out($values,$field)
	{
		if(empty($values)) return $this;
		$this->array[]		=  $field." not in(".implode(',',$values).")";
		return $this;
	}
	/**
	 * 获取查询条件结果
	 *
	 * @return array
	 */
	function string($str)
	{
		if(empty($str)) return $this;
		$this->array[]		=  $str;
		return $this;
	}
	/**
	 * 获取查询条件结果
	 *
	 * @return array
	 */
	function getArray()
	{
		return $this->array;
	}
	/**
	 *清除对象中的查询数组
	 *
	 * @return array
	 */
	function reset()
	{
		$this->array=null;
		return $this;
	}
	
	function parseConditions()
    {
        // 对于 NULL，直接返回 NULL
        if (is_null($this->array)) { return null; }

        // 如果不是数组，说明提供的查询条件有误
        if (!is_array($this->array)) {
            return null;
        }

        $where = '';
        $linksWhere = array();
        $expr = '';

        foreach($this->array as $offset => $cond)
		{
            $expr = 'AND';
        /**
                     * 不过何种条件形式，一律转换为 (字段名, 值, 操作, 连接运算符, 值是否是SQL命令) 的形式
                    */
            if (is_string($offset)) 
			{
                if (!is_array($cond))
				{
                    // 字段名 => 值
                    $cond = array($offset, $cond);
                }
				else 
				{
                    if (strtolower($offset) == 'in()')
					{
                        if (count($cond) == 1 && is_array(reset($cond)) && is_string(key($cond))) 
						{
                            $tmp = ' IN (' . implode(',', array_map(reset($cond))). ')';
                        } else {
                            $tmp = ' IN (' . implode(',', array_map($cond)). ')';
                        }
                        $cond = array('', $tmp, '', $expr, true);
                    } 
					else 
					{
                        // 字段名 => 数组
                        array_unshift($cond, $offset);
                    }
                }
            } elseif (is_int($offset)) 
			{
                if (!is_array($cond))
				{
                    // 值
                    $cond = array('', $cond, '', $expr, true);
                }
            } 
			else 
			{
                continue;
            }
            if (!isset($cond[0])) { continue; }
            if (!isset($cond[2])) { $cond[2] = '='; }
            if (!isset($cond[3])) { $cond[3] = $expr; }
            if (!isset($cond[4])) { $cond[4] = false; }
            list($field, $value, $op, $expr, $isCommand) = $cond;
            $str = '';
            do {
                if (strpos($field, '.') !== false) {
                    list($scheme, $field) = explode('.', $field);
                    $linkname = strtoupper($scheme);	
                    $field = "{$scheme}.{$field}";
                }

                if (!$isCommand)
				{
                    $str = "{$field} {$op} {$value} {$expr} ";
                } 
				else
				{
                    $str = "{$value} {$expr} ";
                }
            } while (false);
            $where .= $str;
        }
        $where = substr($where, 0, - (strlen($expr) + 2));
        if (empty($linksWhere)) 
		{
            return $where;
        }
		else 
		{
            return array($where, $linksWhere);
        }
    }
	
	function getWhere() 
	{
        // 处理查询条件
        $where = $this->parseConditions();

        $sqljoin = '';
        $distinct = '';

        do {
            if (!is_array($where)) 
			{
                $whereby = $where != '' ? " WHERE {$where}" : '';
                break;
            }

            $arr = $where;
            list($where, $linksWhere) = $arr;
            unset($arr);

            if (!$this->autoLink || !$queryLinks) 
			{
                $whereby = $where != '' ? " WHERE {$where}" : '';
                break;
            }

            foreach ($linksWhere as $linkid => $lws) 
			{
                if (!isset($this->links[$linkid]) || !$this->links[$linkid]->enabled) 
				{
                    continue;
                }

                $link =& $this->links[$linkid];
                /* @var $link FLEA_Db_TableLink */
                if (!$link->init) { $link->init(); }
                $distinct = 'DISTINCT ';
				
                $lw = reset($lws);
                if (isset($lw[3])) {
                    $whereby = $where != '' ? " WHERE {$where} {$lw[3]} " : ' WHERE';
                } else {
                    $whereby = $where != '' ? " WHERE {$where} AND " : ' WHERE';
                }
                foreach ($lws as $lw) {
                    list($field, $value, $op, $expr, $isCommand) = $lw;
                    if (!$isCommand) {
                        $field = $link->assocTDG->qfield($field);
                        $value = $this->dbo->qstr($value);
                        $whereby .= " {$field} {$op} {$value} {$expr}";
                    } else {
                        $whereby .= " {$value} {$expr}";
                    }
                }
                $whereby = substr($whereby, 0, - (strlen($expr) + 1));

                unset($link);
            }

            $whereby = " {$sqljoin} {$whereby}";
        } while (false);

  
        return $whereby;
      
    }

}


?>