<?php
/*
Template Name: single-post
*/
?>

<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div id="each_post">
		<div id="post-title"><?php the_title(); ?></div>	
		<div id="post-header">
			<div id="post-thumb">
			<?php
			global $post;
			$thumb = get_post_meta($post->ID, 'wpcf-thumb', true);
			$intro = get_post_meta($post->ID, 'wpcf-intro', true);
			?>
				<img src="<?php echo $thumb ;?>" alt="">
			</div>

			<div id="post-info">
				<p><?php echo $intro ;?></p>
			</div>
		</div>
		<div id="post-main">
			<?php the_content(); ?>
		</div>
	</div>
<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>