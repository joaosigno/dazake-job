</div>
<div id="info" class="justify">
	<div class="infobox" id="info_blog">
		<div class="info">

		<a href="<?php query_posts('category_name=blog&showposts=1'); ?>
			<?php while (have_posts()) : the_post(); ?><?php the_permalink(); ?><?php endwhile; ?>" target="_blank"><span class="title">Up Coming <span class="brankets"> >></span></span></a>
			<div class="info_content">
			<?php query_posts('category_name=blog&showposts=1'); ?>
			<?php while (have_posts()) : the_post(); ?>
			<p><?php the_content();?></p>
			<?php endwhile; ?>
			</div>
		</div>
	</div>
<!-- 	//news -->
	
	<div class="infobox" id="info_news">
		<div class="info">
			<a href="<?php query_posts('category_name=news&showposts=1'); ?>
				<?php while (have_posts()) : the_post(); ?><?php the_permalink();?><?php endwhile; ?>" target="_blank"><span class="title">News <span class="brankets"> >></span></span></a>
			<div class="info_content">
				<?php query_posts('category_name=news&showposts=1'); ?>
				<?php while (have_posts()) : the_post(); ?>	
				<p><?php the_content();?></p>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
	
	
	<div class="infobox" id="info_facebook">
		<div class="info">
			<a href="http://www.facebook.com/pages/Ztem/265593056850630" target="_blank"><span class="title">Facebook <span class="brankets"> >></span></span></a>
			<div class="info_content">
				<?php query_posts('category_name=facebook&showposts=1'); ?>
				<?php while (have_posts()) : the_post(); ?>	
				<p><?php the_content();?></p>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</div>

<div id="footer" class="justify">
	
	<a href="<?php echo site_url(); ?>/?page_id=98" id="contact_us">Contact Us</a>
	<div id="footer_logo">
	<a id="twitter" href="https://twitter.com/#!/ZtemStone">
		<img src="<?php bloginfo('template_directory'); ?>/images/twitter_icon.png" alt="">
	</a>
	<a id="facebook" href="http://www.facebook.com/pages/Ztem/265593056850630">
		<img src="<?php bloginfo('template_directory'); ?>/images/facebook_icon.png" alt="">
	</a>
	<a id="gplus">
		<img src="<?php bloginfo('template_directory'); ?>/images/gplus_icon.png" alt="">
	</a>
	</div>
	
</div>
</div>
</body>
</html>