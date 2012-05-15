<?php /**  * Tree ������(���޷���)  *  
* @author Kvoid  * @copyright http://kvoid.com  
* @version 1.0 
* @access public  
* @example  *   $tree= new Tree($result);  
*   $arr=$tree->leaf(0);  *   $nav=$tree->navi(15);  */
class class_tree
{     
    private $result;
	private $tmp;
	private $arr;
	private $already = array();
	
	/**      * ���캯��      * 
	* @param array $result �������ݱ�����      
	* @param array $fields �������ݱ��ֶΣ�array(����id,��id)      
	* @param integer $root ��������ĸ�id      */    
	public function class_tree($result, $fields = array('id', 'pid'), $root = 0) 
	{         
	    $this->result = $result;
		$this->fields = $fields;
		$this->root = $root;
		$this->handler();     
	} 
    /**      * �������ݱ���������      */
    private function handler()
	{     
        foreach ($this->result as $node) 
		{        
       		$tmp[$node[$this->fields[1]]][] = $node;   
		}
		krsort($tmp); 
        for ($i = count($tmp); $i > 0; $i--) 
		{           
       		foreach ($tmp as $k => $v) 
			{        
    			if (!in_array($k, $this->already))
				{             
     				if (!$this->tmp)
					{                   
    					$this->tmp = array($k, $v);
						$this->already[] = $k;
						continue; 
					} 
					else 
					{ 
 					    foreach ($v as $key => $value) 
						{             
     						if ($value[$this->fields[0]] == $this->tmp[0])
							{                  
							    $tmp[$k][$key]['child'] = $this->tmp[1];   
								$this->tmp = array($k, $tmp[$k]); 
							}   
						}     
					}     
				}     
			}  
			$this->tmp = null;   
		} 
        $this->tmp = $tmp; 
    }  
	
	/**      * ����ݹ�      */  
	private function recur_n($arr, $id)
	{    
     	foreach ($arr as $v) 
		{       
    		if ($v[$this->fields[0]] == $id) 
			{        
     			$this->arr[] = $v;     
				if ($v[$this->fields[1]] != $this->root) $this->recur_n($arr, $v[$this->fields[1]]);
				
			}  
		}   
	} 
	
    /**      * ����ݹ�      */
    private function recur_p($arr)
	{      
       	foreach ($arr as $v) 
		{          
      		$this->arr[] = $v[$this->fields[0]]; 
            if ($v['child']) $this->recur_p($v['child']);    
		}    
    } 
	
    /**      * �˵� ��ά����      * 
	* @param integer $id ����id     
	* @return array ���ط�֧��Ĭ�Ϸ���������      */   
	public function leaf($id = null)
	{    
       	$id = ($id == null) ? $this->root : $id; 
        return $this->tmp[$id];
	}
	
	/**      * ���� һά����      *      
	* @param integer $id ����id     
	* @return array ���ص��߷���ֱ����������      */    
	public function navi($id) 
	{         
	    $this->arr = null;
		$this->recur_n($this->result, $id);
		krsort($this->arr);
		return $this->arr;   
	} 

    /**      * ɢ�� һά����      *      
	* @param integer $id ����id      
	* @return array ����leaf�����з���id      */    
	public function leafid($id) 
	{         
	    $this->arr = null;
		$this->arr[] = $id;
		$this->recur_p($this->leaf($id));
		return $this->arr;
	}
}
?> 
