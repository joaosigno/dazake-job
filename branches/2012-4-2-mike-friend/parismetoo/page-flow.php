<?php
/*
Template Name: page-flow.php
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

	<div id="flow">
		<div class="row">
			<div id="slideTop" class="span12">
				<div class="row">
					<div class="eachPackage span4" data-slide="-20">
						<img src="<?php echo get_post_meta($thisId, 'wpcf-flow-img1', true);?>" alt="">
						<h4>国内流程</h4>
					</div>

					<div class="eachPackage span4" data-slide="-980">
						<img src="<?php echo get_post_meta($thisId, 'wpcf-flow-img2', true);?>" alt="">
						<h4>国外流程</h4>
					</div>

					<div class="eachPackage span4" data-slide="-1940">
						<img src="<?php echo get_post_meta($thisId, 'wpcf-flow-img3', true);?>" alt="">
						<h4>温馨提示</h4>
					</div>
				</div>
			</div>
		</div>


		<div id="slideContent" class="row">

			<!-- slide1 -->
			<div class="slideContent slide1 span12 activeSlide">

				<div>

					<h3 class="span12">前期沟通</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-in1-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-in1-info', true);?></p>
						</div>
					</div>

				</div>

				<div>

					<h3 class="span12">行程安排</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-in2-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-in2-info', true);?></p>
						</div>
					</div>

				</div>

				<div>

					<h3 class="span12">服装选择</h3><span><a href="">点击选择服装</a></span>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-in3-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-in3-info', true);?></p>
						</div>
					</div>

				</div>

				<div>

					<h3 class="span12">定金支付</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-in4-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-in4-info', true);?></p>
						</div>
					</div>

				</div>

				<div>

					<h3 class="span12">全款支付</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-in5-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-in5-info', true);?></p>
						</div>
					</div>

				</div>

				<div>

					<h3 class="span12">后期制作</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-in6-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-in6-info', true);?></p>
						</div>
					</div>

				</div>

			</div>
			<!-- end slide1 -->

			<!-- slide2 -->
			<div class="slideContent slide2 span12 ">

				<div>

					<h3 class="span12">签证办理</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-out1-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-out1-info', true);?></p>
						</div>
					</div>

				</div>

				<div>

					<h3 class="span12">接机（可选）</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-out2-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-out2-info', true);?></p>
						</div>
					</div>

				</div>

				<div>

					<h3 class="span12">酒店化妆</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-out3-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-out3-info', true);?></p>
						</div>
					</div>

				</div>

				<div>

					<h3 class="span12">包车服务</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-out4-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-out4-info', true);?></p>
						</div>
					</div>

				</div>

				<div>

					<h3 class="span12">午餐</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-out5-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-out5-info', true);?></p>
						</div>
					</div>

				</div>

				<div>

					<h3 class="span12">返回交通</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-out6-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-out6-info', true);?></p>
						</div>
					</div>

				</div>

				<div>

					<h3 class="span12">异地拍摄</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-out7-thumb', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-out7-info', true);?></p>
						</div>
					</div>

				</div>

			</div>
			<!-- end slide2 -->

			<!-- slide3 -->
			<div class="slideContent slide3 span12 ">

				<div>

					<h3 class="span12">温馨提示</h3>

					<div class="row">
						<div class="priceLeft span4">
								<img src="<?php echo get_post_meta($thisId, 'wpcf-flow-img3', true);?>" alt="">
						</div>

						<div class="priceRight span7">
							<p><?php echo get_post_meta($thisId, 'wpcf-fyi-info', true);?></p>
						</div>
					</div>

				</div>

			</div>
			<!-- end slide3 -->

		</div>
	</div>
<?php get_footer(); ?>