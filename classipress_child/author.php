<?php

/**
 * Author profile page
 *
 */

//This sets the $curauth variable
if ( isset($_GET['author_name']) ) :
    $curauth = get_userdatabylogin($author_name);
else :
    $curauth = get_userdata( intval($author) );
endif;


?>

<?php get_header(); ?>

<div class="content">

    <div class="content_botbg">

        <div class="content_res">

			<div id="breadcrumb">

                  <?php if ( function_exists('cp_breadcrumb') ) cp_breadcrumb(); ?>

              </div>


            <!-- left block -->
            <div class="content_left">

                <div class="shadowblock_out">

                    <div class="shadowblock">

                        <h1 class="single dotted"><?php _e('About','appthemes')?> <?php echo($curauth->display_name); ?></h1>

                        <div class="post">

							<div id="user-photo"><?php appthemes_get_profile_pic($curauth->ID, $curauth->user_email, 96) ?></div>

                            <div class="author-main">

								<ul class="author-info">
									<li><strong><?php _e('Member Since:','appthemes');?></strong> <?php echo date_i18n(get_option('date_format'), strtotime($curauth->user_registered)); ?></li>
									
                                    <li><strong><?php _e('Name:','appthemes');?></strong> <?php echo($curauth->first_name); ?> <?php echo($curauth->last_name); ?></li>
                                    <li><strong><?php _e('Ciudad:','appthemes');?></strong> <?php echo($curauth->user_city); ?></li>
                                    <li><strong><?php _e('Tipo de cuenta:','appthemes');?></strong> <?php echo($curauth->user_type); ?><span> - </span><?php echo($curauth->user_broker); ?></li>
                                    
								</ul>

                            </div>


							<h3 class="dotted"><?php _e('Description','appthemes'); ?></h3>
							<p><?php echo $curauth->user_description; ?></p>

							<div class="pad20"></div>

							<h3 class="dotted"><?php _e('Latest items listed','appthemes'); ?> </h3>

							<div class="pad5"></div>

				


							

                        </div><!--/directory-->

                    </div><!-- /shadowblock -->

                </div><!-- /shadowblock_out -->

  <!-- author ads -->

                <?php
                    // show only ads from this author
                    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                    query_posts( array('post_type' => 'ad_listing', 'post_status' => 'publish', 'author' => $curauth->ID, 'paged' => $paged, 'posts_per_page' => 10) );
                ?>

                    <?php get_template_part( 'loop', 'ad_listing' ); ?>
            </div>
            <!-- /content_left -->


            <?php get_sidebar(); ?>

            <div class="clr"></div>


        </div><!-- /content_res -->

    </div><!-- /content_botbg -->

</div><!-- /content -->


<?php get_footer(); ?>



                                
                         