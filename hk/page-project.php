<?php
/*
Template Name: page-project
*/
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<?php get_header();?>
	<?php
		$thisIdArray = array();
		$i = 0;
	    $new = new WP_Query('post_type=project');
    	while ($new->have_posts()) : $new->the_post();
    		$thisIdArray[$i] = get_the_ID();
    		$i++;
	    endwhile;
	?>
		<div id="project">
		
			<div id="midbox">
				<img src="<?php echo get_post_meta($thisIdArray[0], 'wpcf-project-image-1', true)?>" alt="" />
				<img src="<?php echo get_post_meta($thisIdArray[0], 'wpcf-project-image-2', true)?>" alt="" />
				<img src="<?php echo get_post_meta($thisIdArray[0], 'wpcf-project-image-3', true)?>" alt="" />
				<img src="<?php echo get_post_meta($thisIdArray[0], 'wpcf-project-image-4', true)?>" alt="" />
			</div>

			<div id="rightbox">
				<h3>Projects</h3>
				<?php 
					//list terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)
			
					$taxonomy     = 'project_category';
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
					<ul>
						<?php wp_list_categories( $args ); ?>
					</ul>
					<script type="text/javascript">
						$(function(){
							$('#project .cat-item a').each(function(){
								$this = $(this);
								url1 = $this.attr('href');
								url2 = url1.replace('_category',"");
								$this.attr('href', url2);
							});
						});
					</script>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/scroll.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/mouse.js"></script>
	<?php get_footer();?>
