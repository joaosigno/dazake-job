<?php
/*
Template Name: page-stone.php
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/scroll.css" media="all" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/fancybox/jquery.fancybox.css" media="all" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.js"></script>
	
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<?php get_header();?>

		<div id="press">
			<div id="press-left">
				<?php
						$new = new WP_Query( 'post_type=stone' );
						while ($new->have_posts()) : $new->the_post();
						$thisId = get_the_ID();
						?>
						<a class="fancy" href="<?php echo get_post_meta($thisId, 'wpcf-stone1', true)?>"><img class="stone-img" src="<?php echo get_post_meta($thisId, 'wpcf-stone1', true)?>" alt="" /></a>
						<?php
						endwhile;
				?>
			</div>
			<div id="press-right">
				<h3>Stone</h3>
				<?php
					$terms =  get_terms('stone_category');
						
					foreach ($terms as $child) {
						$args2 = array(
							'tax_query' => array(
								array(
									'taxonomy' => 'stone_category',
									'field' => 'slug',
									'terms' => $child->slug
								)
							)
						);
						$new = new WP_Query( $args2 );
				?>
					
				<ul class="press-cate">
					<span><?php echo $child->description; ?></span>
					<ul class="hide press-cate-sub">
					<?php
					while ($new->have_posts()) : $new->the_post();
					?>
						<a href="<?php the_permalink();?>"><li><?php the_title();?></li></a>
					<?php
					endwhile;
					?>
					</ul>
				</ul>
				<?php
				}
				?>
			</div>
		</div>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fancybox/jquery.fancybox.js"></script>
		<script type="text/javascript">
			$(function(){
				$('.press-cate span').click(function(){
					$(this).siblings('.press-cate-sub').slideToggle();
				});
				
				$('.fancy').fancybox();
			});
		</script>
	<?php get_footer();?>