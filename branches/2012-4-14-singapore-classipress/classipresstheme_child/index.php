<?php get_header(); ?>

<div class="content">

	<div class="content_botbg">

		<div class="content_res">

             <?php 
				//if ( file_exists(STYLESHEETPATH . '/featured.php') )//
//	                include_once(STYLESHEETPATH . '/featured.php');
//    	        else
//        	        include_once(TEMPLATEPATH . '/featured.php');
			?>
<?php 	if(function_exists("xtremecarousel")) {		xtremecarousel();	}?>

        <!-- left block -->
        <div class="content_left">


            <div class="tabcontrol">

                                    <ul class="tabnavig"> 
              <li><a href="#block3"><span class="big"><?php _e('Featured Listings','appthemes')?></span></a></li> 
              <li><a href="#block1"><span class="big"><?php _e('Just Listed','appthemes')?></span></a></li> 
              <li><a href="#block2"><span class="big"><?php _e('Most Popular','appthemes')?></span></a></li> 
              <li><a href="#block4"><span class="big"><?php _e('Categories','appthemes')?></span></a></li> 
            </ul> 
             
        <?php remove_action( 'appthemes_after_endwhile', 'cp_do_pagination' ); ?> 
      <?php $post_type_url = get_bloginfo('url').'/'.get_option('cp_post_type_permalink').'/'; ?> 

            <!-- tab 1 --> 
            <div id="block1"> 

              <div class="clr"></div> 

              <div class="undertab"><span class="big"><?php _e('Classified Ads','appthemes') ?> / <strong><span class="colour"><?php _e('Just Listed','appthemes') ?></span></strong></span></div> 

                <?php 
                    // show all ads but make sure the sticky featured ads don't show up first 
                    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; 
                    query_posts( array('post_type' => APP_POST_TYPE, 'ignore_sticky_posts' => 1, 'paged' => $paged) ); 
            global $wp_query; 
            $total_pages = max( 1, absint( $wp_query->max_num_pages ) ); 
                ?> 

                <?php get_template_part( 'loop', 'ad_listing' ); ?> 

        <?php 
            if( $total_pages > 1 ){ ?> 
            <div class="paging"><a href="<?php echo $post_type_url; ?>page/2/"> <?php _e( 'View More Ads', 'appthemes' ); ?> </a></div> 
            <?php } ?> 

            </div><!-- /block1 --> 



            <!-- tab 2 --> 
            <div id="block2"> 

              <div class="clr"></div> 

              <div class="undertab"><span class="big"><?php _e('Classified Ads','appthemes') ?> / <strong><span class="colour"><?php _e('Most Popular','appthemes') ?></span></strong></span></div> 

        <?php get_template_part( 'loop', 'featured' ); ?> 

        <?php global $cp_has_next_page; ?> 
        <?php if($cp_has_next_page){ ?> 
            <div class="paging"><a href="<?php echo $post_type_url; ?>page/2/?sort=popular"> <?php _e( 'View More Ads', 'appthemes' ); ?> </a></div> 
        <?php } ?> 

        <?php wp_reset_query(); ?> 

            </div><!-- /block2 --> 



            <!-- tab 3 --> 
            <div id="block3"> 

              <div class="clr"></div> 

              <div class="undertab"><span class="big"><?php _e('Classified Ads','appthemes') ?> / <strong><span class="colour"><?php _e('Featured Listings','appthemes') ?></span></strong></span></div> 

                <?php 
                    // show all random ads but make sure the sticky featured ads don't show up first 
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
  
                   query_posts(array('post_type' => 'ad_listing', 'ad_cat' => $term->slug, 'caller_get_posts' => 1, 'post__in' => get_option('sticky_posts'), 'paged' => $paged,)); 
  
                ?> 
                <?php get_template_part( 'loop', 'ad_listing' ); ?> 

        <?php 
            if( $total_pages > 1 ){ ?> 
            <div class="paging"><a href="<?php echo $post_type_url; ?>page/2/?sort=Featured Listings"> <?php _e( 'View More Ads', 'appthemes' ); ?> </a></div> 
            <?php } ?> 

            </div><!-- /block3 --> 

            <!-- tab 4 --> 
            <div id="block4"> 
              <div class="clr"></div> 
  
              <div class="undertab"><span class="big"><?php _e('Classified Ads','appthemes') ?> / <strong><span class="colour"><?php _e('Categories','appthemes')?></span></strong></span></div> 
  
              <div class="shadowblock_out"> 
  
                    <div class="shadowblock"> 
  
                        <h2 class="dotted"><?php _e('Ad Categories','appthemes')?></h2> 
  
                        <div id="directory" class="directory <?php if(get_option('cp_cat_dir_cols') == 2) echo 'two'; ?>Col"> 
  
                            <?php echo cp_cat_menu_drop_down(get_option('cp_cat_dir_cols'), get_option('cp_dir_sub_num')); ?> 
  
                            <div class="clr"></div> 
  
                        </div><!--/directory--> 
  
                    </div><!-- /shadowblock --> 
  
                </div><!-- /shadowblock_out --> 

            </div><!-- /block4 -->



              <div class="clr"></div>

              <div class="undertab"><span class="big"><?php _e('Classified Ads','appthemes') ?> / <strong><span class="colour"><?php _e('Random','appthemes') ?></span></strong></span></div>

                <?php
                    // show all random ads but make sure the sticky featured ads don't show up first
                    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                    query_posts( array('post_type' => APP_POST_TYPE, 'ignore_sticky_posts' => 1, 'paged' => $paged, 'orderby' => 'rand') );
		    global $wp_query;
		    $total_pages = max( 1, absint( $wp_query->max_num_pages ) );
                ?>

                <?php get_template_part( 'loop', 'ad_listing' ); ?>

		<?php
		    if( $total_pages > 1 ){ ?>
			<div class="paging"><a href="ads/page/2/?sort=random"> <?php _e( 'View More Ads', 'appthemes' ); ?> </a></div>
		    <?php } ?>

            </div><!-- /block4 -->
            
          </div><!-- /tabcontrol -->

      </div><!-- /content_left -->


            <?php get_sidebar(); ?>


            <div class="clr"></div>

        </div><!-- /content_res -->

    </div><!-- /content_botbg -->

</div><!-- /content -->


<?php get_footer(); ?>
