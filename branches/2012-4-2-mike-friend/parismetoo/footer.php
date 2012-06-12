		<!-- #footer -->
		<div id="footer">
			<a href="<?php get_site_url()?>/?page_id=25"><img src="<?php bloginfo('template_url'); ?>/images/home-footer.png" alt=""></a>
			<span>地址：<?php echo get_post_meta('25', 'wpcf-address', true);?>  联系电话：<?php echo get_post_meta('25', 'wpcf-tel', true);?></span>

			<span id="social-icon">
				<a href="<?php echo get_post_meta('117', 'wpcf-tencent-link', true);?>"><img src="<?php bloginfo('template_url'); ?>/images/qq.jpg" height="41" width="40" alt=""></a>
				<a href="<?php echo get_post_meta('117', 'wpcf-sina-link', true);?>"><img src="<?php bloginfo('template_url'); ?>/images/sina.jpg" height="40" width="40" alt=""></a>
				<a href="<?php echo get_post_meta('117', 'wpcf-facebook-link', true);?>"><img src="<?php bloginfo('template_url'); ?>/images/fb.png" height="40" width="40" alt=""></a>
				<a href="<?php echo get_post_meta('117', 'wpcf-twitter-link', true);?>"><img src="<?php bloginfo('template_url'); ?>/images/twitter.jpg" height="40" width="40" alt=""></a>
				<a href="<?php echo get_post_meta('117', 'wpcf-msn-link', true);?>"><img src="<?php bloginfo('template_url'); ?>/images/msn.jpeg" height="40" width="40" alt=""></a>
			</span>
		</div>
		<!-- end #footer -->
		<!--[if lt IE 10]>
		<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/libs/PIE.js"></script>
		<![endif]-->
	</div>
</body>
</html>