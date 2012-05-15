<?php
/*
Template Name: page-home.php
*/
?>
<!DOCTYPE html <?php bloginfo('template_directory'); ?> "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<?php
	    $new = new WP_Query('post_type=product&posts_per_page=9');
	    $idArray = array();
	    $i = 0;
    	while ($new->have_posts()) : $new->the_post();
    	$thisId = get_the_ID();
    	$idArray[$i] = $thisId;
	    $i ++;
	    endwhile;
	?>
	<?php get_header();?>
	<div class="slideshow" id="slideshow1">
		<a target="_blank" href="<?php echo get_permalink( $idArray[8] );?>" class="slidshow_pic">
			<img src="<?echo get_post_meta($idArray[8], 'wpcf-image1', true);?>" alt="product" style="z-index: 3;"/></a>
		<a target="_blank" href="<?php echo get_permalink( $idArray[5] );?>" class="slidshow_pic">
			<img src="<?echo get_post_meta($idArray[5], 'wpcf-image1', true);?>" alt="product" style="z-index: 2;"/></a>
		<a target="_blank" href="<?php echo get_permalink( $idArray[2] );?>" class="slidshow_pic">
			<img src="<?echo get_post_meta($idArray[2], 'wpcf-image1', true);?>" alt="product" style="z-index: 1;"/></a>
	</div>

	<div class="slideshow" id="slideshow2">
		<a target="_blank" href="<?php echo get_permalink( $idArray[7] );?>" class="slidshow_pic">
			<img src="<?echo get_post_meta($idArray[7], 'wpcf-image1', true);?>" alt="product" style="z-index: 3;"/></a>
		<a target="_blank" href="<?php echo get_permalink( $idArray[4] );?>" class="slidshow_pic">
			<img src="<?echo get_post_meta($idArray[4], 'wpcf-image1', true);?>" alt="product" style="z-index: 2;"/></a>
		<a target="_blank" href="<?php echo get_permalink( $idArray[1] );?>" class="slidshow_pic">
			<img src="<?echo get_post_meta($idArray[1], 'wpcf-image1', true);?>" alt="product" style="z-index: 1;"/></a>
	</div>

	<div class="slideshow" id="slideshow3">
		<a target="_blank" href="<?php echo get_permalink( $idArray[6] );?>" class="slidshow_pic">
			<img src="<?echo get_post_meta($idArray[6], 'wpcf-image1', true);?>" alt="product" style="z-index: 3;"/></a>
		<a target="_blank" href="<?php echo get_permalink( $idArray[3] );?>" class="slidshow_pic">
			<img src="<?echo get_post_meta($idArray[3], 'wpcf-image1', true);?>" alt="product" style="z-index: 2;"/></a>
		<a target="_blank" href="<?php echo get_permalink( $idArray[0] );?>" class="slidshow_pic">
			<img src="<?echo get_post_meta($idArray[0], 'wpcf-image1', true);?>" alt="product" style="z-index: 1;"/></a>
	</div>

	<?php get_footer();?>
