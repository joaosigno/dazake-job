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
	<div id="home">
		<div class="slideshow" id="slideshow1">
			<a target="_blank" href="<?echo get_post_meta(381, 'wpcf-url1-1', true);?>" class="slidshow_pic">
				<img src="<?echo get_post_meta(381, 'wpcf-img1-1', true);?>" alt="product" style="z-index: 3;"/></a>
			<a target="_blank" href="<?echo get_post_meta(381, 'wpcf-url2-1', true);?>" class="slidshow_pic">
				<img src="<?echo get_post_meta(381, 'wpcf-img2-1', true);?>" alt="product" style="z-index: 2;"/></a>
			<a target="_blank" href="<?echo get_post_meta(381, 'wpcf-url3-1', true);?>" class="slidshow_pic">
				<img src="<?echo get_post_meta(381, 'wpcf-img3-1', true);?>" alt="product" style="z-index: 1;"/></a>
		</div>

		<div class="slideshow" id="slideshow2">
			<a target="_blank" href="<?echo get_post_meta(381, 'wpcf-url1-2', true);?>" class="slidshow_pic">
				<img src="<?echo get_post_meta(381, 'wpcf-img1-2', true);?>" alt="product" style="z-index: 3;"/></a>
			<a target="_blank" href="<?echo get_post_meta(381, 'wpcf-url2-2', true);?>" class="slidshow_pic">
				<img src="<?echo get_post_meta(381, 'wpcf-img2-2', true);?>" alt="product" style="z-index: 2;"/></a>
			<a target="_blank" href="<?echo get_post_meta(381, 'wpcf-url3-2', true);?>" class="slidshow_pic">
				<img src="<?echo get_post_meta(381, 'wpcf-img3-2', true);?>" alt="product" style="z-index: 1;"/></a>
		</div>

		<div class="slideshow" id="slideshow3">
			<a target="_blank" href="<?echo get_post_meta(381, 'wpcf-url1-3', true);?>" class="slidshow_pic">
				<img src="<?echo get_post_meta(381, 'wpcf-img1-3', true);?>" alt="product" style="z-index: 3;"/></a>
			<a target="_blank" href="<?echo get_post_meta(381, 'wpcf-url2-3', true);?>" class="slidshow_pic">
				<img src="<?echo get_post_meta(381, 'wpcf-img2-3', true);?>" alt="product" style="z-index: 2;"/></a>
			<a target="_blank" href="<?echo get_post_meta(381, 'wpcf-url3-3', true);?>" class="slidshow_pic">
				<img src="<?echo get_post_meta(381, 'wpcf-img3-3', true);?>" alt="product" style="z-index: 1;"/></a>
		</div>
	</div>

	</div>
<div id="info" class="justify">
	<div class="infobox" id="info_blog">
		<div class="info">

		<a href="<?php query_posts('category_name=blog&showposts=1'); ?>
			<?php while (have_posts()) : the_post(); ?><?php the_permalink(); ?><?php endwhile; ?>" target="_blank"><span class="title">Up Coming <span class="brankets"> >></span></span></a>
			<div class="info_content">
			<?php query_posts('category_name=blog&showposts=1'); ?>
			<?php while (have_posts()) : the_post(); ?>
			<p><?php the_content();?></p>
			<?php endwhile; ?>
			</div>
		</div>
	</div>
<!-- 	//news -->
	
	<div class="infobox" id="info_news">
		<div class="info">
			<a href="<?php query_posts('category_name=news&showposts=1'); ?>
				<?php while (have_posts()) : the_post(); ?><?php the_permalink();?><?php endwhile; ?>" target="_blank"><span class="title">News <span class="brankets"> >></span></span></a>
			<div class="info_content">
				<?php query_posts('category_name=news&showposts=1'); ?>
				<?php while (have_posts()) : the_post(); ?>	
				<p><?php the_content();?></p>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
	
	
	<div class="infobox" id="info_facebook">
		<div class="info">
			<a href="http://www.facebook.com/pages/Ztem/265593056850630" target="_blank"><span class="title">Facebook <span class="brankets"> >></span></span></a>
			<div class="info_content">
				<?php query_posts('category_name=facebook&showposts=1'); ?>
				<?php while (have_posts()) : the_post(); ?>	
				<p><?php the_content();?></p>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</div>
	<?php get_footer();?>
