<?php
/**
 * 查询条件类
 *
 */
class class_order
{
	var $order = null;
	var $orderField     = null;
	var $orderDirection = null;
	
	//构造函数
    function class_order($request)
    {
    	if(isset($request['orderField']) and isset($request['orderDirection']) )
		{
		    $this->orderField     = $request['orderField'];
			$this->orderDirection = $request['orderDirection'];
			if(trim($this->orderField) != '' and trim($this->orderDirection)!='')
			{
		        $this->order = ' order by '. $this->orderField.' '.$this->orderDirection;
			}
		};
    }
	
	function getOrder()
    {
		return $this->order;
    }
	
	function getField()
    {
		return $this->orderField;
    }
	
	function getDirection()
    {
		return $this->orderDirection;
    }
}


?>