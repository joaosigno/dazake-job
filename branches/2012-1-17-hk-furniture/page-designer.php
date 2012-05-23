<?php
/*
Template Name: page-designer
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<?php get_header();?>
	<div id="designer">
		<div id="designer-leftbox">
			<?php 
			//list terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)
	
			$taxonomy     = 'designer_category';
			$orderby      = 'name'; 
			$show_count   = 0;      // 1 for yes, 0 for no
			$pad_counts   = 0;      // 1 for yes, 0 for no
			$hierarchical = 1;      // 1 for yes, 0 for no
			$title        = '';
	
			$args = array(
			  'taxonomy'     => $taxonomy,
			  'orderby'      => $orderby,
			  'show_count'   => $show_count,
			  'pad_counts'   => $pad_counts,
			  'hierarchical' => $hierarchical,
			  'title_li'     => $title
			);
			?>
			<ul id="designer-items">
				<?php wp_list_categories( $args ); ?>
			</ul>
		</div>	
		<div id="designer-rightbox">
			<?php
			    $new = new WP_Query('post_type=designer&posts_per_page=9');
		    	while ($new->have_posts()) : $new->the_post();
		    	$thisId = get_the_ID();
		    ?>
		    	<a href="<?php the_permalink();?>">
		    	<div class="each_designers">
				<img src="<?php echo get_post_meta($thisId, 'wpcf-designer_portrait', true)?>" alt="" class="each_designers_portrait" />
				<h4><?php the_title();?></h4>
				</div>
				</a>
			<?php
			    endwhile;
			?>
		</div>
	</div>
	</div>
	<?php get_footer();?>