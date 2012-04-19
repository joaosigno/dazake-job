<?php get_header(); ?>

<div class="content">

	<div class="content_botbg">
    
		<div class="content_res">

            <?php 
				if ( file_exists(STYLESHEETPATH . '/featured.php') )
	                include_once(STYLESHEETPATH . '/featured.php');
    	        else
        	        include_once(TEMPLATEPATH . '/featured.php');
			?>
            
           <div class="shadowblock_out">

                    <div class="shadowblock">
                    <div class="anunciosprincipal">
                    <p>ANUNCIO</p>
                    </div>
                    <div class="anunciosprincipal">
                    <p>ANUNCIO</p>
                    </div>
                    <div class="anunciosprincipal">
                    <p>ANUNCIO</p>
                    </div>
                    <div class="anunciosprincipal">
                    <p>ANUNCIO</p>
                    </div>
                    <div class="clr"></div>
                    </div>
                    </div>
        <!-- left block -->
        <div class="content_left">

            <?php if ( get_option('cp_home_layout') == 'directory' ) : ?>

                <div class="shadowblock_out">

                    <div class="shadowblock">

                        <h2 class="dotted"><?php _e('Ad Categories','appthemes')?></h2>

                        <div id="directory" class="directory <?php if(get_option('cp_cat_dir_cols') == 2) echo 'two'; ?>Col">


                            <?php echo cp_cat_menu_drop_down(get_option('cp_cat_dir_cols'), get_option('cp_dir_sub_num')); ?>


                            <div class="clr"></div>

                        </div><!--/directory-->

                    </div><!-- /shadowblock -->

                </div><!-- /shadowblock_out -->

            <?php endif; ?>


        <div class="tabcontrol">

            <ul class="tabnavig">
              <li><a href="#block1"><span class="big"><?php _e('Recien publicados','appthemes')?></span></a></li>
              <li><a href="#block2"><span class="big"><?php _e('Destacados','appthemes')?></span></a></li>
              <li><a href="#block3"><span class="big"><?php _e('Random','appthemes')?></span></a></li>
            </ul>
            
	    <?php remove_action( 'appthemes_after_endwhile', 'cp_do_pagination' ); ?>
      <?php $post_type_url = get_bloginfo('url').'/'.get_option('cp_post_type_permalink').'/'; ?>

            <!-- tab 1 -->
            <div id="block1">

              <div class="clr"></div>

              <div class="undertab"><span class="big"><?php _e('Avisos clasificados','appthemes') ?> / <strong><span class="colour"><?php _e('Recién publicados','appthemes') ?></span></strong></span></div>

                <?php
                    // show all ads but make sure the sticky featured ads don't show up first
                    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                    query_posts( array('post_type' => APP_POST_TYPE, 'ignore_sticky_posts' => 1, 'paged' => $paged, 'posts_per_page' => 6) );
		    global $wp_query;
		    $total_pages = max( 1, absint( $wp_query->max_num_pages ) );
                ?>

                <?php get_template_part( 'loop', 'ad_listing' ); ?>

		<?php
		    if( $total_pages > 1 ){ ?>
			<div class="paging"><a href="ads/"> <?php _e( 'Ver más avisos', 'appthemes' ); ?> </a></div>
		    <?php } ?>

            </div><!-- /block1 -->



            <!-- tab 2 -->
            <div id="block2">

              <div class="clr"></div>

              <div class="undertab"><span class="big"><?php _e('Avisos clasificados','appthemes') ?> / <strong><span class="colour"><?php _e('Destacados','appthemes') ?></span></strong></span></div>
              
              
              

		<?php
                    // show all ads but make sure the sticky featured ads don't show up first
query_posts( array('post__in' => get_option('sticky_posts'), 'post_type' => APP_POST_TYPE, 'post_status' => 'publish', 'orderby' => 'rand','posts_per_page' => 6) ); 

                ?>

                <?php get_template_part( 'loop', 'ad_listing' ); ?>
		<?php
		    if( $total_pages > 1 ){ ?>
			<div class="paging"><a href="ads/"> <?php _e( 'Ver más avisos', 'appthemes' ); ?> </a></div>
		    <?php } ?>

            </div>
            
            <!-- /block2 -->


            <!-- tab 3 -->
            <div id="block3">

              <div class="clr"></div>

              <div class="undertab"><span class="big"><?php _e('Classified Ads','appthemes') ?> / <strong><span class="colour"><?php _e('Random','appthemes') ?></span></strong></span></div>

                <?php
                    // show all random ads but make sure the sticky featured ads don't show up first
                    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                    query_posts( array('post_type' => APP_POST_TYPE, 'ignore_sticky_posts' => 1, 'paged' => $paged, 'orderby' => 'rand','posts_per_page' => 6) );
		    global $wp_query;
		    $total_pages = max( 1, absint( $wp_query->max_num_pages ) );
                ?>

                <?php get_template_part( 'loop', 'ad_listing' ); ?>

		<?php
		    if( $total_pages > 1 ){ ?>
			<div class="paging"><a href="<?php echo $post_type_url; ?>page/2/?sort=random"> <?php _e( 'View More Ads', 'appthemes' ); ?> </a></div>
		    <?php } ?>

            </div><!-- /block3 -->

          </div><!-- /tabcontrol -->

      </div><!-- /content_left -->


            <?php get_sidebar(); ?>

            <div class="clr"></div>
            

        </div><!-- /content_res -->

   
    </div><!-- /content_botbg -->

</div><!-- /content -->


<?php get_footer(); ?>
