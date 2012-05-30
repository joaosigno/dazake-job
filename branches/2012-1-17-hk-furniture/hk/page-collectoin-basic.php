<?php
/*
Template Name: page-collection-basic
*/
?>
<!DOCTYPE html <?php bloginfo('template_directory'); ?> "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>
	<?php get_header();?>
	<?php
		$line_type = $_GET['linetype'];
		$type_title = $line_type == 'signatureline' ? 'Signature' : 'Basic';
	?>
	<div id="collection">
		<div id="showbox">
			<?php
				
			    $args = array(
						'tax_query' => array(
							array(
								'taxonomy' => 'product_category',
								'field' => 'slug',
								'terms' => $line_type
							)
						)
					);
					$new = new WP_Query( $args );
		    	while ($new->have_posts()) : $new->the_post();
		    	$thisId = get_the_ID();
			?>
			<!-- <a href="<?php the_permalink()?>" class='test_img'><img src="http://ztem.com/wp-content/uploads/2012/02/IMG_9793.jpg" alt="" /></a> -->
			<a href="<?php the_permalink()?>" class='test_img'><img src="<?php echo get_post_meta($thisId, 'wpcf-image1', true)?>" alt="" /></a>
			
			<?php
			    endwhile;
			?>

		</div>
		
		<div id="show_nav" class="hide">
			<div id="nav_left" class="scroll_nav"><<</div>
			<div id="nav_right" class="scroll_nav">>></div>
		</div>
	</div>
	
	<div id="collection-cate">
		<h3>Ztem Line</h3>
		<div class="collection-cate-block">
			
			<ul>
				<?php
					while ($new->have_posts()) : $new->the_post();
				?>
				<a href="<?php the_permalink();?>">
					<li><?php the_title();?></li>
				</a>
				<?php
					endwhile;
				?>
			</ul>
		</div>
	</div>
	</div>
	<?php get_footer();?>