<?php
/*
Template Name: page-about.php
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/scroll.css" media="all" />
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<?php get_header();?>

		<div id="about">
			<div id="rightbox" class="fakeScroll">
				<?php
					query_posts('category_name=our-company&showposts=1');
					while (have_posts()) : the_post();
					    echo "<div class='about_single'>";
					    echo "<div class='about_single_title'>";
						the_title();
						echo "</div>";
						echo "<div class='about_single_content'>";
						the_content();
						echo "</div>";
						echo "</div>";
					endwhile;
				?>
			</div>
			<div id="rightbox2"  class="fakeScroll">
			</div>
			<div id="waitingbox" >
				<img src="<?php bloginfo('template_directory'); ?>/images/loading.gif" alt="" id="loading"/>
			</div>
			<div id="nav"></div>
			<div id="leftbox">
				<h3>About</h3>
				<div id="items" data-save="<?php echo site_url(); ?>/wp-admin/admin-ajax.php">
					<div id="our-company" data-type="single" class="item mainitem active">Our Company</div>
					<div id="blog" data-type="cate" class="item subitem">Our Blog</div>
					<!-- <div id="quality-environment" data-type="single" class="item subitem">Quality & Environment</div> -->
					<div id="news" data-type="cate" class="item subitem">Latest News</div>
					<div id="press" style="display:none" data-type="cate" class="item subitem">Press</div>
					<div class="item subitem"><a href="http://ztem.com/?page_id=98">Contact Us</a></div>
				</div>
			</div>			
		</div>


		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/scroll.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/mouse.js"></script>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/about.js"></script>
		<script type="text/javascript" id="sourcecode">
			$('#rightbox').jScrollPane();
		</script>
		</div>
		<img class="about-img" src="<?php bloginfo('template_directory'); ?>/images/about.png" height="242" width="430" alt="" />

	<?php get_footer();?>