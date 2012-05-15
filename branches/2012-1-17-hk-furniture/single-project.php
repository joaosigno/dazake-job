<?php
/*
Template Name: single-project
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

	    while (have_posts()) : the_post();
    		$thisId = get_the_ID();
	    endwhile;
	?>
		<div id="project">
			<div id="leftbox">
				<div id="project_preview">
					<img src="<?php echo get_post_meta($thisId, 'wpcf-project-image-1', true)?>" alt="" />
				</div>
				<div id="project_box">
					<?php
						for($j = 0; $j < count($thisIdArray); $j++){
							
					?>
					<a href="<?php echo get_permalink($thisIdArray[$j]);?>">
						<div class="project_item" id="<?php echo get_post_meta($thisIdArray[$j], 'wpcf-project-image-1', true);?>">
							<?php echo get_the_title($thisIdArray[$j]); ?>
						</div>
					</a>
					<?php
						}
					?>
				</div>
			</div>
		
			<div id="midbox">
				<img src="<?php echo get_post_meta($thisId, 'wpcf-project-image-1', true)?>" alt="" />
			</div>

			<div id="rightbox">
				<div id="project_name">
					Description
				</div>

				<div id="project_desc">
					<?php 
						 $thisConent = get_post_meta($thisId, 'wpcf-project-description', true);
						 getFormatContent($thisConent);
					?>
				</div>

				<div id="project_display">
					<img src="<?php echo get_post_meta($thisId, 'wpcf-project-image-2', true)?>" alt="" />
					<img src="<?php echo get_post_meta($thisId, 'wpcf-project-image-3', true)?>" alt="" />
					<img src="<?php echo get_post_meta($thisId, 'wpcf-project-image-4', true)?>" alt="" />
				</div>
			</div>
		</div>
		
	<?php get_footer();?>
