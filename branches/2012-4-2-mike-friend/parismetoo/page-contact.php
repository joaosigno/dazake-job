<?php
/*
Template Name: page-contact.php
*/
?>
<?php get_header(); ?>
	<div id="contact" class="row">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php
			$thisId = get_the_ID();
			$title = get_the_title();
		?>
		<?php endwhile;?>
		<?php endif; ?>
		<div class="row">
			<h3 class="pageTitle span2">联系我们:</h3>
		</div>

		<div id="contactDetail" class="row">
			<div class="eachContactDetail">
				<label for="">地址:</label>
				<span class="eachContact"><?php echo get_post_meta($thisId, 'wpcf-address', true);?></span>
			</div>
			<div class="eachContactDetail">
				<label for="">手机:</label>
				<span class="eachContact"><?php echo get_post_meta($thisId, 'wpcf-tel', true);?></span>
			</div>
			<div class="eachContactDetail">
				<label for="">QQ:</label>
				<span class="eachContact"><?php echo get_post_meta($thisId, 'wpcf-qq', true);?></span>
			</div>
			<div class="eachContactDetail">
				<label for="">MSN:</label>
				<span class="eachContact"><?php echo get_post_meta($thisId, 'wpcf-msn', true);?></span>
			</div>
			<div class="eachContactDetail">
				<label for="">QQ群:</label>
				<span class="eachContact"><?php echo get_post_meta($thisId, 'wpcf-qq-group', true);?></span>
			</div>
			<div class="eachContactDetail">
				<label for="">新浪微博:</label>
				<span class="eachContact"><img src="" alt=""></span>
			</div>
			<div class="eachContactDetail">
				<label for="">QQ微博:</label>
				<span class="eachContact"><img src="" alt=""></span>
			</div>
			<div class="eachContactDetail">
				<label for="">公交:</label>
				<span class="eachContact"><?php echo get_post_meta($thisId, 'wpcf-bus', true);?></span>
			</div>
			<div class="eachContactDetail">
				<label for="">地铁:</label>
				<span class="eachContact"><?php echo get_post_meta($thisId, 'wpcf-subway', true);?></span>
			</div>
		</div>
		<div id="googlemap" class="row">
			<!-- for google map -->
			<?php 
				if ( have_posts() ) : while ( have_posts() ) : the_post(); 

				the_content();
				endwhile; else:
				endif;
			?>
		</div>
	</div>	
<?php get_footer(); ?>