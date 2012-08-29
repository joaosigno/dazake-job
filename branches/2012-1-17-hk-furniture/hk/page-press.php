<?php
/*
Template Name: page-press.php
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/scroll.css" media="all" />
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<?php get_header();?>

		<div id="press">
			<div id="press-left">
				<?php
						$new = new WP_Query( 'post_type=press' );
						while ($new->have_posts()) : $new->the_post();
						$thisId = get_the_ID();
						?>
						<a href="<?php the_permalink()?>"><img class="press-logo-img" src="<?php echo get_post_meta($thisId, 'wpcf-press-logo', true)?>" alt="" /></a>
						<?php
						endwhile;
				?>
			</div>
			<div id="press-right">
				<h3>Press</h3>
				<?php
					$terms =  get_terms('press_category');
						
					foreach ($terms as $child) {
						$args2 = array(
							'tax_query' => array(
								array(
									'taxonomy' => 'press_category',
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
		<script type="text/javascript">
			$(function(){
				$('.press-cate span').click(function(){
					$(this).siblings('.press-cate-sub').slideToggle();
				});
			});
		</script>
	<?php get_footer();?>