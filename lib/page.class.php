<?php
	class page
	{
		public $pagesize;
		private $lastpage;
		private $totalpages;
		private $nums;
		private $numPage=1;
		
		function __construct($page_size,$total_nums)
		{
			$this->pagesize=$page_size;		//每页显示的数据条数
			$this->nums=$total_nums;		//总的数据条数
			$this->lastpage=ceil($this->nums/$this->pagesize);		//最后一页
			$this->totalpages=ceil($this->nums/$this->pagesize);	//总得分页数
			if(!empty($_SESSION['page']))
			{
				$this->numPage=$_SESSION['page'];
				if(!is_int($this->numPage))	$this->numPage=(int)$this->numPage;
				if($this->numPage<1)	$this->numPage=1;
				if($this->numPage>$this->lastpage)	$this->numPage=$this->lastpage;
			}
			
			$_SESSION['lastpage'] = $this->lastpage;
		}

    	function show_page_result()
		{
			$row_num=(($this->numPage)-1) * $this->pagesize; //表示每一页从第几条数据开始显示
			return $row_num ;		
		}
	}
?>