<?php
session_start();
include_once( '../class/config.php' );
include_once( '../class/saetv2.ex.class.php' );
header("Content-type: text/html; charset=utf-8");
$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['weibo_token']['access_token'] );


//评论功能
if(isset($_POST['pinglunid'])&&isset($_POST['neirong'])){
	$c->send_comment($_POST['pinglunid'],$_POST['neirong']);
}

//转发功能
if(isset($_POST['zhuanfaid'])&&isset($_POST['zhuanfa'])){
	$c->repost($_POST['zhuanfaid'],$_POST['zhuanfa']);
}

$pl = $c->get_comments_by_sid($_POST['weibomid']);//获取评论列表
$bq = $c->emotions();		//读取表情
?>

<div class="submit_comment">
	<form action="">
		<textarea name="" class="comment_text" cols="30" rows="10"></textarea>
		<div class="comment_button" alt="">评论</div>
	</form>
	
	<div class="comment_biaoqing">
		<span class="comment_biaoqing_trigger"></span>
	</div>
	<div class="comment_biaoqing_floatbox hide">
		<ul>
			<?php
				for($i=0;$i<64;$i++){
				echo '<li class="comment_biaoqing_img"><img src="'.$bq[$i]['icon'].'" alt="'.$bq[$i]['phrase'].'" /></li>';
				}
			?>
		</ul>
	</div>
</div>
<div class="comment_list">
	<div class="each_comment">
		<?php   
		if( is_array( $pl['comments'] ) ){
			foreach( $pl['comments'] as $item ){
		?>
			<div class="each_comment">
			<span><a href=""><?php echo $item['user']['name'] ;?>:</a><span class="comment_content"><?php echo $c->text_to_bq($item['text'],$bq);?></span></span>
			</div>
		<?php 
				}
			}
		?>
	</div>

</div>
<script type="text/javascript" src="js/biaoqing_trigger.js"></script>