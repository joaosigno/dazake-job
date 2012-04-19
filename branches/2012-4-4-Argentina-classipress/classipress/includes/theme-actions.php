<?php
/**
 * Adds all action hooks for the theme
 *
 * @since 3.1
 * @uses add_action() calls to trigger the hooks.
 *
 */
 

/**
 * add the ad price field in the loop before the ad title 
 * @since 3.1.3
 */
function cp_ad_loop_price() {
	if ( is_page() ) return; // don't do ad-meta on pages
	global $post;
?>		
	<div class="price-wrap">
        <span class="tag-head">&nbsp;</span><p class="post-price"> 
        
        <span style="font-size:10px;"><?php echo get_post_meta($post->ID, 'cp_divisa', true); ?>  </span>
		
		
		<?php if ( get_post_meta( $post->ID, 'price', true ) ) cp_get_price_legacy( $post->ID ); else cp_get_price( $post->ID, 'cp_price' ); ?></p>
    </div>

<?php
}
add_action( 'appthemes_before_post_title', 'cp_ad_loop_price' );


/**
 * add the ad meta in the loop after the ad title 
 * @since 3.1
 */
function cp_ad_loop_meta() {
	if ( is_page() || is_singular( APP_POST_TYPE ) ) return; // don't do ad-meta on pages
	global $post;
?>	
    <p class="post-meta">
        <span class="folder"><?php if ( get_the_category() ) the_category(', '); else echo get_the_term_list( $post->ID, APP_TAX_CAT, '', ', ', '' ); ?></span> | <span class="owner"><?php if ( get_option('cp_ad_gravatar_thumb') == 'yes' ) appthemes_get_profile_pic( get_the_author_meta('ID'), get_the_author_meta('user_email'), 16 ) ?><?php the_author_posts_link(); ?></span> | <span class="clock"><span><?php echo appthemes_date_posted($post->post_date); ?></span></span>
        
        <li class="agregadosloop">
        
        <span style="color: #F60; font-weight:bold;"><?php echo get_post_meta($post->ID, 'cp_estado', true); ?> </span>
        
        | <?php echo get_post_meta($post->ID, 'cp_marca', true); ?>, <?php echo get_post_meta($post->ID, 'cp_modelo', true); ?> 
        
        | <?php echo get_post_meta($post->ID, 'cp_city', true); ?>, <?php echo get_post_meta($post->ID, 'cp_state', true); ?>  
          </li>
        
        
    </p>
<?php
}
add_action( 'appthemes_after_post_title', 'cp_ad_loop_meta' );


/**
 * add the stats after the ad listing and blog post content 
 * @since 3.1
 */
function cp_do_loop_stats() {
	if ( is_page() || is_singular( array( 'post', APP_POST_TYPE ) ) ) return; // don't do on pages
	global $post;
?>		
	<p class="stats"><?php if ( get_option('cp_ad_stats_all') == 'yes' ) appthemes_get_stats( $post->ID ); ?></p>
<?php
}
add_action( 'appthemes_after_post_content', 'cp_do_loop_stats' );
add_action( 'appthemes_after_blog_post_content', 'cp_do_loop_stats' );


/**
 * add the ad reference ID after the ad listing content 
 * @since 3.1.3
 */
function cp_do_ad_ref_id() {
	if ( !is_singular( APP_POST_TYPE ) ) return;
	global $post;
?>		
	<div class='note'><strong><?php _e( 'Ad Reference ID:', 'appthemes' ); ?></strong> <?php if ( get_post_meta( $post->ID, 'cp_sys_ad_conf_id', true ) ) echo get_post_meta( $post->ID, 'cp_sys_ad_conf_id', true ); else echo __( 'N/A', 'appthemes' ); ?></div>
    <div class="dotted"></div>
    <div class="pad5"></div>
<?php
}
add_action( 'appthemes_after_post_content', 'cp_do_ad_ref_id' );


/**
 * add the pagination after the ad listing and blog post content 
 * @since 3.1
 */
function cp_do_pagination() {
	
	if ( is_page() || is_singular( 'post' ) ) return; // don't do on pages, the home page, or single blog post
	global $post;

    if ( function_exists('appthemes_pagination') ) appthemes_pagination();

}
add_action('appthemes_after_endwhile', 'cp_do_pagination');
add_action('appthemes_after_blog_endwhile', 'cp_do_pagination');


/**
 * add the no ads found message 
 * @since 3.1
 */
function cp_ad_loop_else() {
?>		
    <div class="shadowblock_out">

		<div class="shadowblock">

			<div class="pad10"></div>

			<p><?php _e('Sorry, no listings were found.','appthemes')?></p>

			<div class="pad50"></div>
        
		</div><!-- /shadowblock -->

	</div><!-- /shadowblock_out -->
<?php
}
add_action('appthemes_loop_else', 'cp_ad_loop_else');


/**
 * Blog section actions
 *
 */

/**
 * add the post meta after the blog post title 
 * @since 3.1
 */
function cp_blog_post_meta() {
	if ( is_page() ) return; // don't do post-meta on pages
	global $post;
?>		
	<p class="meta dotted"><span class="user"><?php the_author_posts_link(); ?></span> | <span class="folderb"><?php the_category(', ') ?></span> | <span class="clock"><span><?php echo appthemes_date_posted( $post->post_date ); ?></span></span></p>
<?php
}
add_action('appthemes_after_blog_post_title', 'cp_blog_post_meta');


/**
 * add the blog post meta footer content 
 * @since 3.1.3
 */
function cp_blog_post_meta_footer() {
    if ( !is_singular( array( 'post', APP_POST_TYPE ) ) ) return;
	global $post;
?>		
	<div class="prdetails">
	    <?php if ( is_singular( 'post' ) ) { ?>
        <p class="tags"><?php if ( get_the_tags() ) echo the_tags( '', '&nbsp;', '' ); else echo __( 'No Tags', 'appthemes' ); ?></p>
        <?php } else { ?>
        <p class="tags"><?php if ( get_the_term_list( $post->ID, APP_TAX_TAG ) ) echo get_the_term_list( $post->ID, APP_TAX_TAG, '', '&nbsp;', '' ); else echo __('No Tags', 'appthemes'); ?></p>
        <?php } ?>
        <?php if ( get_option( 'cp_ad_stats_all') == 'yes' ) { ?><p class="stats"><?php appthemes_stats_counter( $post->ID ); ?></p> <?php } ?>
        <p class="print"><?php if ( function_exists('wp_email') ) email_link(); ?>&nbsp;&nbsp;<?php if ( function_exists('wp_print') ) print_link(); ?></p>
        <?php edit_post_link( '<p class="edit">'.__( 'Edit Post', 'appthemes' ), '', '' ).'</p>'; ?>
    </div>
    
    <?php if ( function_exists('selfserv_sexy') ) selfserv_sexy(); 
}
add_action('appthemes_after_blog_post_content', 'cp_blog_post_meta_footer');
add_action('appthemes_after_post_content', 'cp_blog_post_meta_footer');


/**
 * add the no blog posts found message 
 * @since 3.1
 */
function cp_blog_loop_else() {
?>		
    <p><?php _e('Sorry, no posts could be found.','appthemes'); ?></p>
<?php
}
add_action('appthemes_blog_loop_else', 'cp_blog_loop_else');


/**
 * add the comments bubble 
 * @since 3.1.3
 */
function cp_blog_comments_bubble() {
?>		
    <div class="comment-bubble"><?php comments_popup_link( '0', '1', '%' ); ?></div>
<?php
}
add_action( 'appthemes_before_blog_post_title', 'cp_blog_comments_bubble' );


/**
 * add the blog and ad listing single page banner ad 
 * @since 3.1.3
 */
function cp_single_ad_banner() {
    if ( !is_singular( array( 'post', APP_POST_TYPE ) ) ) return;
	global $post;
	
    // show the ad block if it's been activated
    if ( get_option( 'cp_adcode_336x280_enable' ) == 'yes' ) :

        if ( function_exists( 'appthemes_single_ad_336x280' ) ) { ?>

        <div class="shadowblock_out">

            <div class="shadowblock">

              <h2 class="dotted"><?php _e( 'Sponsored Links', 'appthemes' ) ?></h2>

              <?php appthemes_single_ad_336x280(); ?>

            </div><!-- /shadowblock -->

        </div><!-- /shadowblock_out -->

        <?php } 
        
    endif; 
}
add_action( 'appthemes_after_blog_loop', 'cp_single_ad_banner' );
add_action( 'appthemes_after_loop', 'cp_single_ad_banner' );


// DO NOT PUT A CLOSING  "? >" at the end of this file. Causes strange issues with category creation in the admin console.				
