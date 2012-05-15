<?php
/*
Template Name: single-post
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<?php get_header();?>
	<?php
		// query_posts('category_name=our-company&showposts=1');
		while (have_posts()) : the_post();
	?>
		<div class='single_post'>
		    <div class='single_post_title'>
			<?php the_title();?>
			</div>
			<div class="post_date">
			<span class="arrow-right"></span>
			<?php the_date('', '<span class="date-num">', '</span>'); ?>
			</div>
			<div class='single_post_content'>
			<?php the_content(); ?>
			</div>
			<?php previous_post_link('<div class="pre_post">Prev:%link</div>'); ?>
			<?php next_post_link('<div class="next_post">Next:%link</div>'); ?>
		</div>
	<?php
		endwhile;
	?>
	<?php get_footer();?>
