<?php
/*
Template Name: page-about.php
*/
?>
<?php get_header(); ?>
	
	<div id="about-us">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php
			$thisId = get_the_ID();
			$title = get_the_title();
		?>
		<?php endwhile;?>
		<?php endif; ?>
		<div class="titleArea row">
			<span class="row"><h2 id="aboutTitle" class="span4 offset4"><?php echo $title;?></h2></span>
			<p class="content row"></p>
		</div>

		<!-- each person introduction -->
		<div class="aboutContentArea row">

			<div class="aboutEachPerson">

				<h3 class="row"><?php echo get_post_meta($thisId, 'wpcf-user1-name', true);?></h3>

				<div class="aboutLeft span4">
						<img src="<?php echo get_post_meta($thisId, 'wpcf-user1-portrait', true);?>" alt="">
					</div>
				</div>

				<div class="aboutRight span7">
					<p><?php echo get_post_meta($thisId, 'wpcf-user1-info', true);?></p>
				</div>

			</div>
			<!-- end each person introduction -->

			<!-- each person introduction -->
		<div class="aboutContentArea row">

			<div class="aboutEachPerson">

				<h3 class="row"><?php echo get_post_meta($thisId, 'wpcf-user2-name', true);?></h3>

				<div class="aboutLeft span4">
						<img src="<?php echo get_post_meta($thisId, 'wpcf-user2-portrait', true);?>" alt="">
					</div>
				</div>

				<div class="aboutRight span7">
					<p><?php echo get_post_meta($thisId, 'wpcf-user2-info', true);?></p>
				</div>

			</div>
			<!-- end each person introduction -->

			<!-- each person introduction -->
		<div class="aboutContentArea row">

			<div class="aboutEachPerson">

				<h3 class="row"><?php echo get_post_meta($thisId, 'wpcf-user3-name', true);?></h3>

				<div class="aboutLeft span4">
						<img src="<?php echo get_post_meta($thisId, 'wpcf-user3-portrait', true);?>" alt="">
					</div>
				</div>

				<div class="aboutRight span7">
					<p><?php echo get_post_meta($thisId, 'wpcf-user3-info', true);?></p>
				</div>

			</div>
			<!-- end each person introduction -->

			<!-- each person introduction -->
		<div class="aboutContentArea row">

			<div class="aboutEachPerson">

				<h3 class="row"><?php echo get_post_meta($thisId, 'wpcf-user4-name', true);?></h3>

				<div class="aboutLeft span4">
						<img src="<?php echo get_post_meta($thisId, 'wpcf-user4-portrait', true);?>" alt="">
					</div>
				</div>

				<div class="aboutRight span7">
					<p><?php echo get_post_meta($thisId, 'wpcf-user4-info', true);?></p>
				</div>

			</div>
			<!-- end each person introduction -->

	</div>

<?php get_footer(); ?>