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
			<h3>Designers</h3>
			<ul id="designer-items">
				<?php 
					$new = new WP_Query('post_type=designer');
		    	while ($new->have_posts()) : $new->the_post();
		    ?>
		    		<li class="each-designer"><?php the_title()?></li>
		    <?php
			    endwhile;
				?>
			</ul>
		</div>	
		<div id="designer-rightbox">
			<div id="designers-box">
				<div id="designers-box-inner">
				<?php
				while ($new->have_posts()) : $new->the_post();
				$thisId = get_the_ID();
				?>
		    <div class="each_designers">
				<img src="<?php echo get_post_meta($thisId, 'wpcf-designer_portrait', true)?>" alt="" class="each_designers_portrait" />
				<span class="description hide"><?php echo get_post_meta($thisId, 'wpcf-designer-description', true)?></span>
				</div>
				<?php
					endwhile;
				?>
				</div>
			</div>
			
			<div id="description-box"></div>
		</div>
	</div>
	</div>
	<script type="text/javascript">
		$(function(){
			$('.each_designers').mouseover(function(){
				$(this).siblings('.each_designers').addClass('designerHover');
				$('#description-box').append($(this).find('.description').text());
			});
			$('.each_designers').mouseout(function(){
				$(this).siblings('.each_designers').removeClass('designerHover');
				$('#description-box').empty();
			});
		});
	</script>
	<?php get_footer();?>