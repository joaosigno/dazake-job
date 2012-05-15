<?php
/*
Template Name: page-collection
*/
?>
<!DOCTYPE html <?php bloginfo('template_directory'); ?> "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/fancybox.css" media="all" />
	<script type="text/javascript">
		$('document').ready(function(){
			$(".test_img").fancybox({
				'width'				: 1000,
				'height'			: 600,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});
		})
	</script>
	<?php get_header();?>
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
	<div id="collection">
		<div id="showbox">
			<?php
			    $new = new WP_Query('post_type=product&posts_per_page=8');
		    	while ($new->have_posts()) : $new->the_post();
		    	$thisId = get_the_ID();
			?>
			<a href="<?php echo site_url(); ?>/?page_id=65&id=<?php echo $thisId?>" class='test_img'><img src="<?php echo get_post_meta($thisId, 'wpcf-image1', true)?>" alt="" /></a>
			<?php
			    endwhile;
			?>

		</div>
		
		<div id="show_nav" class="hide">
			<div id="nav_left" class="scroll_nav"><</div>
			<div id="nav_right" class="scroll_nav">></div>
		</div>
	</div>
	<?php get_footer();?>