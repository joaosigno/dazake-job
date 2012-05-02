<?php
/*
Template Name: page-contact.php
*/
?>
<?php get_header(); ?>
	<div id="contact" class="row">
		<div class="row">
			<h3 class="pageTitle span2">联系我们:</h3>
		</div>

		<div id="contactDetail" class="span5">
			<div class="eachContactDetail">
				<label for="">地址:</label>
				<span class="eachContact">上海市安远路839号</span>
			</div>
			<div class="eachContactDetail">
				<label for="">手机:</label>
				<span class="eachContact">134235233123</span>
			</div>
			<div class="eachContactDetail">
				<label for="">QQ:</label>
				<span class="eachContact">435345233</span>
			</div>
			<div class="eachContactDetail">
				<label for="">MSN:</label>
				<span class="eachContact">fsdu@hotmail.com</span>
			</div>
			<div class="eachContactDetail">
				<label for="">QQ群:</label>
				<span class="eachContact">324666454</span>
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
				<span class="eachContact"><img src="" alt=""></span>
			</div>
			<div class="eachContactDetail">
				<label for="">地铁:</label>
				<span class="eachContact"><img src="" alt=""></span>
			</div>
		</div>
		<div id="googlemap" class="span7">
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