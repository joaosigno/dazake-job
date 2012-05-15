<?php
// ���ú���

// �������,urlת��
	function text_to_bq( $str,  $bq ){
		$str = str_replace('"',' ',$str);
		foreach($bq as $item){
		$str =  str_replace($item['emotion'],'<img src="'.$item['icon'].'"/>',$str);
		}
		return $str;
	}
	
// �������ж�
	function type_judge($item){
		$result;
		$statu = array(10);//����״̬
		$blog = array(20);//������־
		$album = array(30);//�ϴ���Ƭ
		$share = array(21,32,33,50,51,52);
		
		if(in_array($item['feed_type'],$statu)){
			$result = 'statu';	
		}
		if(in_array($item['feed_type'],$blog)){
			$result = 'blog';	
		}
		if(in_array($item['feed_type'],$album)){
			if(count($item['attachment'])>1){
				$result = 'album';
			}else{
				$result = 'photo';
			}	
		}
		if(in_array($item['feed_type'],$share)){
			$result = 'share';	
		}
		
		return $result;
	}
	
//����������ʹ�������
 	function show_comment_data($item){
		$type = type_judge($item);
		echo '<div class="comment_ajax hide">';
		echo '<span class="type">'.$type.'</span>';//����
		echo '<span class="owner_id">'.$item['actor_id'].'</span>';//��Դ������id
			if($type=='photo'){
				echo '<span class="src_id">'.$item['attachment'][0]['media_id'].'</span>';//��Դid
			}else{
				echo '<span class="src_id">'.$item['source_id'].'</span>';//��Դid
			}
		echo '</div>';	
	
	
	}
	
//�Ƿ����ϲ���ж�
	function isCanLike($item){
		if(type_judge($item)=='statu'){
			return 0;
		}else{
			return 1;
		}
	}
