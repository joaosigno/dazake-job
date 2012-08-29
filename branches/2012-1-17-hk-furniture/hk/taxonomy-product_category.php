<?php
/*
Template Name: taxonomy-product_category
*/
?>
<!DOCTYPE html <?php bloginfo('template_directory'); ?> "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/fancybox.css" media="all" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fancybox.js"></script>
	<title>COLLECTION</title>
	<?php get_header();?>
	<?php 
		$term =	$wp_query->queried_object;
		echo '<div id="currentCate">'.$term->name.'</div>';
	 ?>
	<?php
		if(function_exists('wp_nav_menu')):
				wp_nav_menu(
						array(
						'menu' =>'Pro_nav',
						'container'=>'',
						'depth' => 2,
						'menu_id' => 'Pro_nav' )
				);
		else:
	?>
	<?php wp_list_pages('title_li=&depth=2'); ?>
	<?php
		endif;
	?>
	<div id="product_category">
		<?php 
			while (have_posts()) : the_post();
			$thisId = get_the_ID();
		?>
			
				<a href="<?php the_permalink();?>">
					<div class="each_product">
						<img src="<?php echo get_post_meta($thisId, 'wpcf-image1', true)?>" alt="" class="	each_product_img" />
						<div class="each_product_name"><?php the_title();?></div>
					</div>
				</a>
		<?php
			endwhile;
		 ?>
	</div>
	<script type="text/javascript">
		$('document').ready(function(){
			$('#pro_nav_trigger').addClass('showcate_active');
			$('#Pro_nav').show();
			$('#currentCate').show();
		});
	</script>
	<?php get_footer();?>