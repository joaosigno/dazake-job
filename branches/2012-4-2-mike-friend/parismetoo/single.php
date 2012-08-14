<?php
/*
Template Name: single-post
*/
?>

<?php get_header(); ?>
<div id="single-post">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div id="single-post-title">
		<h3><?php the_title();?></h3>
	</div>
	<div id="single-post-content">
		<?php the_content();?>
	</div>

	<?php endwhile; ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>