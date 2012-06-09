<?php
/*
Template Name: page-works.php
*/
?>
<?php get_header(); ?>
	<div id="works">

		<!-- #category for love -->
		<div class="worksCate">

			<div class="row cateTitle">
				<h3 class="span5">死生契阔</h3>
			</div>
			
<?php 
$args=array(
	'taxonomy'=>'picture_category',
  'term' => 'friends',
  'post_type' => 'pictures',
  'showposts' => '9'
);
$friendsPosts = new WP_Query($args);     
?> 
			<div class="row">
<?php while ($friendsPosts->have_posts()) : $friendsPosts->the_post(); ?> 
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
		<!-- end #category for love -->

		<!-- #category for myself -->
		<div class="worksCate">

			<div class="row cateTitle">
				<h3 class="span5">一个人的狂欢</h3>
			</div>
			
			<div class="row">
				<?php 
$args=array(
	'taxonomy'=>'picture_category',
  'term' => 'alone',
  'post_type' => 'pictures',
  'showposts' => '3'
);
$alonePosts = new WP_Query($args);     
?> 
<?php while ($friendsPosts->have_posts()) : $friendsPosts->the_post(); ?> 
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
		<!-- end #category for myself -->

		<!-- #category for friends -->
		<div class="worksCate">

			<div class="row cateTitle">
				<h3 class="span5">闺蜜我最大</h3>
			</div>
			
			<div class="row">
				<div class="cover span4 sold">
					<a href="" ><img class="lazy" data-original="<?php bloginfo('template_url'); ?>/images/blank.jpg" src="<?php bloginfo('template_url'); ?>/images/1.jpg" alt=""></a>
					<a href=""><h4>test</h4></a>
				</div>
				<div class="cover span4">
					<a href="" ><img class="lazy" data-original="<?php bloginfo('template_url'); ?>/images/blank.jpg" src="<?php bloginfo('template_url'); ?>/images/2.jpg" alt=""></a>
					<a href=""><h4>test</h4></a>
				</div>
				<div class="cover span4">
					<a href="" ><img class="lazy" data-original="<?php bloginfo('template_url'); ?>/images/blank.jpg" src="<?php bloginfo('template_url'); ?>/images/3.jpg" alt=""></a>
					<a href=""><h4>test</h4></a>
				</div>
			</div>

		</div>
		<!-- end #category for friends -->

		<!-- #category for travel -->
		<div class="worksCate">

			<div class="row cateTitle">
				<h3 class="span5">微电影</h3>
			</div>
			
			<div class="row">
				<div class="cover span4 sold">
					<a href="" ><img class="lazy" data-original="<?php bloginfo('template_url'); ?>/images/blank.jpg" src="<?php bloginfo('template_url'); ?>/images/1.jpg" alt=""></a>
					<a href=""><h4>test</h4></a>
				</div>
				<div class="cover span4">
					<a href="" ><img class="lazy" data-original="<?php bloginfo('template_url'); ?>/images/blank.jpg" src="<?php bloginfo('template_url'); ?>/images/2.jpg" alt=""></a>
					<a href=""><h4>test</h4></a>
				</div>
				<div class="cover span4">
					<a href="" ><img class="lazy" data-original="<?php bloginfo('template_url'); ?>/images/blank.jpg" src="<?php bloginfo('template_url'); ?>/images/3.jpg" alt=""></a>
					<a href=""><h4>test</h4></a>
				</div>
			</div>

		</div>
		<!-- end #category for travel -->
</div>
<?php get_footer(); ?>