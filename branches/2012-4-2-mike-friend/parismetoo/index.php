<?php get_header(); ?>
			<div id="showcase">
				<div class="row">
<?php 
$args=array(
	'taxonomy'=>'picture_category',
  'term' => 'front-page',
  'post_type' => 'pictures',
  'showposts' => '9'
);
$picturePosts = new WP_Query($args);
?> 

				<?php while ( $picturePosts->have_posts() ) : $picturePosts->the_post(); ?>
					<div class="cover span4 sold">
					
					<?php
					$thumb = get_post_meta($post->ID, 'wpcf-thumb', true);
					$sale = get_post_meta($post->ID, 'wpcf-sale', true);
?>
						<a href="<?php the_permalink(); ?>" >
						<?php if($sale): ?>
							<span class="solde"></span>
						<?php endif; ?>
						<img class="lazy" data-original="<?php bloginfo('template_url'); ?>/images/blank.jpg" src="<?php echo $thumb; ?>" alt=""></a>
						<a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
					</div>
					<?php endwhile; // End the loop. Whew. ?>
				</div>
			</div>
		</div>

		<h4 id="slide-info-title">最新资讯:</h4>
		<div id="slide-info">
	    <div class="JQ-content-box">
		
	      <ul class="JQ-slide-content">
		    <?php 
$args=array(
	'taxonomy'=>'picture_category',
  'term' => 'zuixinzixun',
  'post_type' => 'pictures',
  'showposts' => '5'
);
$recentPosts = new WP_Query($args);     
?> 
<?php while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?> 
	      	<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
<?php endwhile; ?>  
	      </ul>
		  
	    </div>
	  </div>


		<!-- end #main -->

		
<?php get_footer(); ?>