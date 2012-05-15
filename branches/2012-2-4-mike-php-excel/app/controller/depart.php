<?php
/////////////////////////////////////////////////////////////////////////////
/**
 * ����depart������
 *
 *  ���Ź�����
 */
///////////////////////////////////////////////////////////////////////////
//���ؿ���������
FLEA::loadClass('controller_base');
FLEA::loadClass('class_using');
FLEA::loadClass('class_tree');

class controller_depart extends controller_base
{
    var $_model;
    var $_title;
	
    //���캯��
    function controller_depart()
    {
	    //��ʼ��ģ��
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
		
		//ͨ������������
		//@param:$arrs ���ṹ����
		//@param:$keyparam  ��ʾ���ֶ� ���磺array('code','name') ���ڵ㽫��ʾ�� ����-���ơ� ��ʽ
		//@param:$$outparam ˫���ڵ������ֵ���ֶ�
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
                        echo '})\' title="˫��ѡ��" ';
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
		    //���ɲ������ṹ
		    $tree = new class_tree($departs);
            $departs = $tree->leaf(0);
			//���ò���
		    $this->_smarty->assign('arrs',$departs);
			$this->_smarty->assign('keyparam',array('code','name'));
			$this->_smarty->assign('outparam',array('id','code','name'));
			
		    $this->_smarty->display('departlookup.htm');
		}
    }
	

}
