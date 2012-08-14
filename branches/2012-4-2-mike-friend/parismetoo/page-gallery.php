<?php
/*
Template Name: page-gallery.php
*/
?>
<?php get_header(); ?>
	<div id="gallery">
		<?php 
		$args=array(
			'taxonomy'=>'picture_category',
		  'term' => 'gallery',
		  'post_type' => 'pictures',
		  'showposts' => '9'
		);
		$galleryPosts = new WP_Query($args);     
		?> 
		<div class="row">
			<?php while ($galleryPosts->have_posts()) : $galleryPosts->the_post(); ?> 
			<?php
								$thumb = get_post_meta($post->ID, 'wpcf-thumb', true);
								$sale = get_post_meta($post->ID, 'wpcf-sale', true);
			?>
							<div class="cover span4">
								<a href="<?php the_permalink(); ?>" ><img class="lazy" data-original="<?php bloginfo('template_url'); ?>/images/blank.jpg" src="<?php echo $thumb ;?>" alt=""></a>
								<a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
							</div>
			<?php endwhile; ?>
		</div>
	</div>
<?php get_footer(); ?>