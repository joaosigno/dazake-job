<?php get_header(); ?>

<script type='text/javascript'>
// <![CDATA[
/* setup the form validation */
jQuery(document).ready(function ($) {
    $('#mainform').validate({
        errorClass: 'invalid'
    });
});
// ]]>
</script>

<?php // if($_GET['reportpost'] == $post->ID) { app_report_post($post->ID); $reported = true;} ?>

<div class="content">

    <div class="content_botbg">

        <div class="content_res">
        
         
                                <!-- /Ad arriba del anuncio -->
							<div class="ad-dentro-anuncio_out">

                   				 <div class="ad-dentro-anuncio">    
                                 
                                 <div style="width:900px; padding:5px;">               		 		
	
                     				 <div style="float:left;"> <script type="text/javascript"><!--
google_ad_client = "ca-pub-5716127590845388";
/* Mercadobarcos leaderboard anuncios */
google_ad_slot = "2953359603";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
<div style="float:left; padding:20px;">
<a href="http://mercadobarcos.com/contacto/publicidad/" target="_new"><h3>Su publicidad aquí</h3></a></div>

<div style="clear:both"></div>

</div>

                  		 		 </div><!-- /shadowblock -->

             			   </div><!-- /shadowblock_out -->
                           

            <div id="breadcrumb">

                <?php if ( function_exists('cp_breadcrumb') ) cp_breadcrumb(); ?>

            </div>

            <!-- <div style="width: 105px; height:16px; text-align: right; float: left; font-size:11px; margin-top:-10px; padding:0 10px 5px 5px;"> -->
                <?php // if($reported) : ?>
                    <!-- <span id="reportedPost"><?php _e('Post fue reportado', 'appthemes'); ?></span> -->
                <?php // else : ?>
                    <!--	<a id="reportPost" href="?reportpost=<?php echo $post->ID; ?>"><?php _e('Reportar este post','appthemes') ?></a> -->
                <?php // endif; ?>
			<!-- </div> -->

            <div class="clr"></div>

            <div class="content_left">

	            <?php appthemes_before_loop(); ?>

		        <?php if ( have_posts() ) : ?>

			        <?php while ( have_posts() ) : the_post() ?>

			            <?php appthemes_before_post(); ?>

				        <?php appthemes_stats_update( $post->ID ); //records the page hit ?>

				        <div class="shadowblock_out">

					        <div class="shadowblock">

                                <?php appthemes_before_post_title(); ?>

							    <h1 class="single-ad"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>

							    <div class="clr"></div>

							    <?php appthemes_after_post_title(); ?>

							    <div class="pad5 dotted"></div>

                                <div class="bigright"<?php if(get_option($GLOBALS['app_abbr'].'_ad_images') == 'no') echo 'style="float:none;"'; ?>>

                                    <ul>

                                        <?php
                                        // grab the category id for the functions below
                                        $cat_id = appthemes_get_custom_taxonomy( $post->ID, APP_TAX_CAT, 'term_id' );

                                        // check to see if ad is legacy or not
                                        if ( get_post_meta( $post->ID, 'expires', true ) ) {  ?>

                                            <li><span><?php _e('Ubicación:', 'appthemes') ?></span> <?php echo get_post_meta( $post->ID, 'location', true ); ?></li>
                                            <li><span><?php _e('Teléfono:', 'appthemes') ?></span> <?php echo get_post_meta( $post->ID, 'phone', true ); ?></li>

                                            <?php if ( get_post_meta( $post->ID, 'cp_adURL', true ) ) ?>
                                                <li><span><?php _e('URL:','appthemes'); ?></span> <?php echo appthemes_make_clickable( get_post_meta( $post->ID, 'cp_adURL', true ) ); ?></li>

                                            <li><span><?php _e('Publicado:', 'appthemes') ?></span> <?php the_time( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) ?></li>
                                            <li><span><?php _e('Vence:', 'appthemes') ?></span> <?php echo cp_timeleft( strtotime( get_post_meta( $post->ID, 'expires', true ) ) ); ?></li>

                                        <?php
                                        } else {

                                            if ( get_post_meta($post->ID, 'cp_ad_sold', true) == 'yes' ) : ?>
                                            <li id="cp_sold"><span><?php _e('Este artículo ha sido vendido', 'appthemes'); ?></span></li>
                                            <?php endif; ?>
                                            <?php
                                            // 3.0+ display the custom fields instead (but not text areas)
                                            cp_get_ad_details( $post->ID, $cat_id );
                                        ?>

                                            <li id="cp_listed"><span><?php _e('Publicado:', 'appthemes') ?></span> <?php the_time( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) ) ?></li>

                                            <?php if ( get_post_meta($post->ID, 'cp_sys_expire_date', true) ) ?>
                                                <li id="cp_expires"><span><?php _e( 'Vence:', 'appthemes' ) ?></span> <?php echo cp_timeleft( strtotime( get_post_meta( $post->ID, 'cp_sys_expire_date', true) ) ); ?></li>

                                        <?php
                                        } // end legacy check
                                        ?>

                                    </ul>

                                </div><!-- /bigright -->


                                <?php if ( get_option( 'cp_ad_images' ) == 'yes' ) : ?>

                                    <div class="bigleft">

                                        <div id="main-pic">

                                            <?php cp_get_image_url(); ?>

                                            <div class="clr"></div>

                                        </div>

                                        <div id="thumbs-pic">

                                            <?php cp_get_image_url_single( $post->ID, 'thumbnail', $post->post_title, -1 ); ?>

                                            <div class="clr"></div>

                                        </div>

                                    </div><!-- /bigleft -->

                                <?php endif; ?>
                               

				                <div class="clr"></div>
                                
                                <!-- /Ad dentro del anuncio -->
							<div class="ad-dentro-anuncio_out">

                   				 <div class="ad-dentro-anuncio">                   		 		
	
                     				 <div align='center'>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-5716127590845388";
/* Individual mercadobarcos */
google_ad_slot = "8658867188";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>

                  		 		 </div><!-- /shadowblock -->

             			   </div><!-- /shadowblock_out -->
                           
                           
                           
                           
				                <?php appthemes_before_post_content(); ?>

                                <div class="single-main">

                                    <?php
                                    // 3.0+ display text areas in content area before content.
                                    cp_get_ad_details( $post->ID, $cat_id, 'content' );
                                    ?>

                                    <h3 class="description-area"><?php _e( 'Description', 'appthemes' ); ?></h3>

                                    <?php the_content(); ?>

                                </div>
                                
                                <br>
								<p class="dotted"></p>
								<br>
							<H3>Mapa</H3>
								<br>
									<?php include_once ( TEMPLATEPATH . '/includes/sidebar-gmap.php' ); ?> 

                                <?php appthemes_after_post_content(); ?>

                            </div><!-- /shadowblock -->

                        </div><!-- /shadowblock_out -->

                        <?php appthemes_after_post(); ?>

			        <?php endwhile; ?>

			            <?php appthemes_after_endwhile(); ?>

			        <?php else: ?>

			            <?php appthemes_loop_else(); ?>

                    <?php endif; ?>

                    <div class="clr"></div>

                    <?php appthemes_after_loop(); ?>

                    <?php wp_reset_query(); ?>

                    <div class="clr"></div>

                    <?php comments_template( '/comments-ad_listing.php' ); ?>

            </div><!-- /content_left -->

            <?php get_sidebar( 'ad' ); ?>

            <div class="clr"></div>

        </div><!-- /content_res -->

    </div><!-- /content_botbg -->

</div><!-- /content -->

<?php get_footer(); ?>
