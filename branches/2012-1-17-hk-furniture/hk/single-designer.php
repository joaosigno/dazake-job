<?php
/*
Template Name: page-designer
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>DESIGNERS</title>
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
			<div id="single-designer-box">
				<div id="single-designer-upper">
				<?php
					// query_posts('category_name=our-company&showposts=1');
					while (have_posts()) : the_post();
					$thisId = get_the_ID();
				?>
					<div id="single_designer_info">
						<div id="single_designer_portrait" >
							<img src="<?php echo get_post_meta($thisId, 'wpcf-designer_portrait', true)?>" alt=""/>
						</div>
						<div id="single_designer_name"><?php the_title(); ?></div>
						<div id="single_desinger_email"><?php echo get_post_meta($thisId, 'wpcf-designer_email', true)?></div>
					</div>
					<div id="single_designer_description">
						<h6>Introduction:</h6>
						<?php getFormatContent(get_post_meta($thisId, 'wpcf-designer-description', true));?>
					</div>
				</div>
					<div id="single_designer_works">
						<h6>Display:</h6>
						<div id="single_designer_workbox">
						<?php $thisCate = get_the_title(); 
							$args = array(
								'tax_query' => array(
									array(
										'taxonomy' => 'designer_category',
										'field' => 'slug',
										'terms'  => $thisCate
									)
								)
							);
							$query = new WP_Query( $args );
							while ($query->have_posts()) : $query->the_post();
							$thisCateId = get_the_ID();
							$posttype = get_post_type($thisCateId);
							if($posttype == 'product'){
						?>
							<a href="<?php the_permalink();?>">
							<div class="single_designer_eachwork">
									<img src="<?php echo get_post_meta($thisCateId, 'wpcf-image1', true)?>" alt="" />
									<h5><?php the_title();?></h5>
							</div>
							</a>
						<?php
							}
							endwhile;
						?>
	
					</div>
				<?php
					endwhile;
				?>
				</div>
			</div>
		</div>
	</div>
	<?php get_footer();?>