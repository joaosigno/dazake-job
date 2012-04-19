<?php

    $start = $paged * 10;

    // Add an additional entry to test for a next page
    $end = $start + 10 + 1;

    // give us the most popular ads based on page views
    $sql = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "cp_ad_pop_total a "
    . "INNER JOIN " . $wpdb->posts . " p ON p.ID = a.postnum "
    . "WHERE postcount > 0 AND post_status = 'publish' AND post_type = '".APP_POST_TYPE."' "
    . "ORDER BY postcount DESC LIMIT $start,$end" );

    $pageposts = $wpdb->get_results( $sql );

    global $cp_has_next_page;
    if(count($pageposts) == 11){
	$cp_has_next_page = true;
    }else{
	$cp_has_next_page = false;
    }
    
    $pageposts = array_slice( $pageposts, 0, 10);

    ?>

<?php if ( $pageposts ) : ?>

    <?php foreach ( $pageposts as $post ) : ?>

	 <?php setup_postdata( $post ); ?>

	    <div class="post-block-out">

		      <div class="post-block">

			      <div class="post-left">

				<?php if ( get_option('cp_ad_images') == 'yes' ) cp_ad_loop_thumbnail(); ?>

			      </div>

			      <div class="<?php if(get_option('cp_ad_images') == 'yes') echo 'post-right'; else echo 'post-right-no-img'; ?> <?php echo get_option('cp_ad_right_class'); ?>">

				    <?php appthemes_before_post_title(); ?>

				      <h3><a href="<?php the_permalink(); ?>"><?php if ( mb_strlen(get_the_title()) >= 75 ) echo mb_substr( get_the_title(), 0, 75 ).'...'; else the_title(); ?></a></h3>

				      <div class="clr"></div>

				      <?php appthemes_after_post_title(); ?>

				      <div class="clr"></div>

				      <?php appthemes_before_post_content(); ?>

				      <p class="post-desc"><?php echo mb_substr( strip_tags($post->post_content), 0, 150 ).'...';?></p>

				      <?php appthemes_after_post_content(); ?>

				      <div class="clr"></div>

			      </div>

			      <div class="clr"></div>

		      </div><!-- /post-block -->

	    </div><!-- /post-block-out -->

<?php endforeach; ?>

<?php else: ?>

	<div class="shadowblock_out">

	    <div class="shadowblock">

		<div class="pad10"></div>

		<p><?php _e('Sorry, no listings were found.','appthemes')?></p>

		<div class="pad50"></div>

	    </div><!-- /shadowblock -->

	</div><!-- /shadowblock_out -->

<?php endif; ?>