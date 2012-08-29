<?php
/*
Template Name: page-fancybox
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css" media="all">
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/main.js"></script>
	<?php $new = new WP_Query('post_type=product&posts_per_page=1');
    	while ($new->have_posts()) : $new->the_post();
    	$thisId = $_GET['id'];
	 ?>
	<div id="pro_detail">
			<div id="leftbox">
				<div id="pro_show"><img src="<?php echo get_post_meta($thisId, 'wpcf-image1', true)?>" alt=""  /></div>
				<div id="pro_detail_pic">
					<div class="pro_detail_pic_img">
						<div class="imgcover"></div>
						<img src="<?php echo get_post_meta($thisId, 'wpcf-image2', true)?>" alt="" />
					</div>
					<div class="pro_detail_pic_img">
						<div class="imgcover"></div>
						<img src="<?php echo get_post_meta($thisId, 'wpcf-image3', true)?>" alt="" />
					</div>
					<div class="pro_detail_pic_img">
						<div class="imgcover"></div>
						<img src="<?php echo get_post_meta($thisId, 'wpcf-image4', true)?>" alt="" />
					</div>
				</div>
			</div>
			<div id="rightbox">
				<?php 
					$arg = array(
						'style'    => 'span',
						'title_li' => __( '' ),
						'taxonomy' => 'designers_category'
						); 
				?> 
				<h3 id="pro_name"><?php echo get_the_title($thisId);?></h3>
				<?php 
				   	function getDesigner($id){
				   		$designerNameObject = wp_get_post_terms($id,'designer_category' );
					   	$designerNum = count($designerNameObject);
					   	for($i = 0; $i < $designerNum; $i++){
					   		$designerNameArray[$i] = get_object_vars($designerNameObject[$i]);
					   		$designerName[$i] = $designerNameArray[$i]["name"];
					   		$args[$i]=array(
							  'name' => $designerName[$i],
							  'post_type' => 'designer',
							  'post_status' => 'publish',
							  'showposts' => 1,
							  'caller_get_posts'=> 1
							);
							$my_posts[$i] = get_posts($args[$i]);
							$designerLink[$i] = get_permalink($my_posts[$i][0]->ID); 
							$thisContent .= '<a href="'.$designerLink[$i].'"><span id="pro_designer">'.$designerName[$i].'</span></a>';
					   	}
					   	echo $thisContent;
				   	}
				?>
				<h5>Designer:<?php getDesigner($thisId);?></h5>
				<label for="pro_size">Size:</label>
				<div id="pro_size">
					<?php 
						$wpcf_height = get_post_meta($thisId, 'wpcf-height', true);
						$wpcf_width = get_post_meta($thisId, 'wpcf-width', true);
						$wpcf_length = get_post_meta($thisId, 'wpcf-length', true);
						$wpcf_diameter = get_post_meta($thisId, 'wpcf-diameter', true);

						if(!$wpcf_diameter){
							echo $wpcf_length ." L x ". $wpcf_width ." W x ". $wpcf_height ." H (CM) ";
						}else{
							echo $wpcf_diameter ." Diameter x ".$wpcf_height." H (CM) ";
						}
					?>
				</div>
				<label for="pro_desc">Description:</label>
				<div id="pro_disc">
					<?php getFormatContent(get_post_meta($thisId, 'wpcf-product-description', true));?>
				</div>
			</div>
		</div>
		<?php endwhile;?>
