<?php
/*
Template Name: page-price.php
*/
?>
<?php get_header(); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php
		$thisId = get_the_ID();
		$title = get_the_title();
	?>
	<?php endwhile;?>
	<?php endif; ?>

	<div id="price">
		<div class="row">
			<div id="slideTop" class="span12">
				<div class="row">
					<div class="eachPackage span4" data-slide="-20">
						<img src="<?php echo get_post_meta($thisId, 'wpcf-price-thumb1', true);?>" alt="">
						<h4>和他</h4>
					</div>

					<div class="eachPackage span4" data-slide="-980">
						<img src="<?php echo get_post_meta($thisId, 'wpcf-price-thumb2', true);?>" alt="">
						<h4>和她</h4>
					</div>

					<div class="eachPackage span4" data-slide="-1940">
						<img src="<?php echo get_post_meta($thisId, 'wpcf-price-thumb3', true);?>" alt="">
						<h4>和自己</h4>
					</div>
				</div>
			</div>
		</div>


		<div id="slideContent" class="row">

			<!-- slide1 -->
			<div class="slideContent slide1 span12 activeSlide">

				<div>

					<h3 class="span12"><?php echo get_post_meta($thisId, 'wpcf-with-him', true);?></h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-price-thumb1', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-package1', true);?></p>
						</div>
					</div>

				</div>

			</div>
			<!-- end slide1 -->

			<!-- slide2 -->
			<div class="slideContent slide2 span12 ">

				<div>

					<h3 class="span12"><?php echo get_post_meta($thisId, 'wpcf-with-her', true);?></h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-price-thumb2', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-package2', true);?></p>
						</div>
					</div>

				</div>

			</div>
			<!-- end slide2 -->

			<!-- slide3 -->
			<div class="slideContent slide3 span12 ">

				<div>

					<h3 class="span12"><?php echo get_post_meta($thisId, 'wpcf-with-myself', true);?></h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-price-thumb3', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-package3', true);?></p>
						</div>
					</div>

				</div>

			</div>
			<!-- end slide3 -->

		</div>

	</div>
<?php get_footer(); ?>