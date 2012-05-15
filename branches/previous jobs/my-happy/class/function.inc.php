<?php
// 常用函数

// 输出表情,url转换
	function text_to_bq( $str,  $bq ){
		$str = str_replace('"',' ',$str);
		foreach($bq as $item){
		$str =  str_replace($item['emotion'],'<img src="'.$item['icon'].'"/>',$str);
		}
		return $str;
	}
	
// 类型做判定
	function type_judge($item){
		$result;
		$statu = array(10);//更新状态
		$blog = array(20);//发表日志
		$album = array(30);//上传照片
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
	
//输出评论类型传输数据
 	function show_comment_data($item){
		$type = type_judge($item);
		echo '<div class="comment_ajax hide">';
		echo '<span class="type">'.$type.'</span>';//类型
		echo '<span class="owner_id">'.$item['actor_id'].'</span>';//资源所有者id
			if($type=='photo'){
				echo '<span class="src_id">'.$item['attachment'][0]['media_id'].'</span>';//资源id
			}else{
				echo '<span class="src_id">'.$item['source_id'].'</span>';//资源id
			}
		echo '</div>';	
	
	
	}
	
//是否可以喜欢判断
	function isCanLike($item){
		if(type_judge($item)=='statu'){
			return 0;
		}else{
			return 1;
		}
	}
