<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * 定义depart控制器
 *
 *  部门管理器
 */
///////////////////////////////////////////////////////////////////////////
//加载控制器基类
FLEA::loadClass('controller_base');
FLEA::loadClass('class_using');
FLEA::loadClass('class_tree');

class controller_depart extends controller_base
{
    var $_model;
    var $_title;
	
    //构造函数
    function controller_depart()
    {
	    //初始化模板
	    $this->initView();
	    $this->checkLogin();
    }
	
    //
    function actionindex()
    {
	    $this->_model =& FLEA::getSingleton('model_user');
    }
	
	
	//
    function actionlookup()
    {
		$this->_model =& FLEA::getSingleton('model_depart');
        $departs = $this->_model->findAll();
		
		//通用生成树函数
		//@param:$arrs 树结构数组
		//@param:$keyparam  显示的字段 例如：array('code','name') ，节点将显示“ 编码-名称” 形式
		//@param:$$outparam 双击节点带回数值的字段
		function maketree($arrs,$keyparam,$outparam)
        {
			if(isset($arrs) && is_array($arrs))
			{		
			    foreach($arrs as $arr)
				{    
                    echo '<li>';
					echo '<a ';
				    if(isset($outparam) && is_array($outparam))
					{
				        echo 'ondblclick=\'javascript:$.bringBack({';
                        for ($i = 0; $i < count($outparam); $i++) 
						{
						    if ($i > 0) echo ',';
						    echo $outparam[$i].':"'.$arr[$outparam[$i]].'"';
                        }
                        echo '})\' title="双击选中" ';
					}
					echo '>';
					if(isset($keyparam) && is_array($keyparam))
					{
                        for ($i = 0; $i < count($keyparam); $i++) 
						{
						    if ($i > 0) echo '-';
							echo $arr[$keyparam[$i]];
                        }
					}                 
					echo '</a>';					
				    if(isset($arr['child']))
				    {
					    echo '<ul>';
						maketree($arr['child'],$keyparam,$outparam);
                        echo '</ul>';						
				    }
                    echo '</li>';					
				}
			}
        }
		
		if (isset($departs))
		{
		    //生成部门树结构
		    $tree = new class_tree($departs);
            $departs = $tree->leaf(0);
			//设置参数
		    $this->_smarty->assign('arrs',$departs);
			$this->_smarty->assign('keyparam',array('code','name'));
			$this->_smarty->assign('outparam',array('id','code','name'));
			
		    $this->_smarty->display('departlookup.htm');
		}
    }
	

}
