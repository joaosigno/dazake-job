<?php global $app_abbr; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php wp_title(''); ?></title>

    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('feedburner_url') <> "" ) echo get_option('feedburner_url'); else echo get_bloginfo_rss('rss2_url').'?post_type='.APP_POST_TYPE; ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <?php if ( is_singular() && get_option('thread_comments') ) wp_enqueue_script('comment-reply'); ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php appthemes_before(); ?>

        <div class="container">

		    <?php if ( get_option('cp_debug_mode') == 'yes' ) { ?><div class="debug"><h3><?php _e('Debug Mode On','appthemes'); ?></h3><?php print_r($wp_query->query_vars); ?></div><?php } ?>

            <?php appthemes_before_header(); ?>
            <!-- HEADER -->
    <div class="header">

        <div class="header_top">

            <div class="header_top_res">

                <p>
                <a href="<?php echo home_url() ; ?> ">Advertise With Us </a>| <a href=" <?php echo home_url() ; ?>/contact-us/">Contact Us</a>
                <?php echo cp_login_head(); ?>

                <a href="<?php if (get_option('cp_feedburner_url')) echo get_option('cp_feedburner_url'); else echo get_bloginfo_rss('rss2_url').'?post_type='.APP_POST_TYPE; ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/icon_rss.gif" width="16" height="16" alt="rss" class="srvicon" /></a>

                <?php if ( get_option('cp_twitter_username') ) : ?>
                    &nbsp;|&nbsp;
                    <a href="http://twitter.com/<?php echo get_option('cp_twitter_username'); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/icon_twitter.gif" width="16" height="16" alt="tw" class="srvicon" /></a>
                <?php endif; ?>
                </p>

            </div><!-- /header_top_res -->

        </div><!-- /header_top -->


        <div class="header_main">

            <div class="header_main_bg">

                <div class="header_main_res">

                    <div id="logo">

                        <?php if ( get_option('cp_use_logo') != 'no' ) { ?>

                            <?php if ( get_option('cp_logo') ) { ?>
                                <a href="<?php echo home_url(); ?>"><img src="<?php echo get_option('cp_logo'); ?>" alt="<?php bloginfo('name'); ?>" class="header-logo" /></a>
                            <?php } else { ?>
                                <a href="<?php echo home_url(); ?>"><div class="cp_logo"></div></a>
                            <?php } ?>

                        <?php } else { ?>

                            <h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
                            <div class="description"><?php bloginfo('description'); ?></div>

                        <?php } ?>

                    </div><!-- /logo -->

                    <?php if ( get_option('cp_adcode_468x60_enable') == 'yes' ) { ?>

                        <div class="adblock">

                            <?php //appthemes_header_ad_468x60();?>

                            <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar_dazake_head') ) : else : ?> <!-- no dynamic sidebar so don't do anything --> <?php endif; ?>

                        </div><!-- /adblock -->

                    <?php } ?>

                    <div class="clr"></div>

                </div><!-- /header_main_res -->

            </div><!-- /header_main_bg -->

        </div><!-- /header_main -->


        <div class="header_menu">

            <div class="header_menu_res">
            <?php 
            //local live chat
             $locallivechat = get_option('locallivechat');
            $locallivechat = stripslashes($locallivechat);
            if(!empty($locallivechat)){
                echo '<div id = "locallivechat" class = "displaynone" >';
                echo $locallivechat;
                echo '</div>';
            }

            ?>

                <a href="<?php echo CP_ADD_NEW_URL ?>" class="obtn btn_orange"><?php _e('Post an Ad', 'appthemes') ?></a>

                <ul id="nav"> 
                
                    <li class="<?php if (is_home()) echo 'page_item current_page_item'; ?>"><a href="<?php echo get_option('home')?>"><?php _e('Home','appthemes'); ?></a></li>
                    <li class="mega"><a href="#"><?php _e('Categories','appthemes'); ?></a>
                        <div class="adv_categories" id="adv_categories">

                        <?php echo cp_cat_menu_drop_down( get_option('cp_cat_menu_cols'), get_option('cp_cat_menu_sub_num') ); ?>

                        </div><!-- /adv_categories -->
                    </li>
    
                </ul>
    
                <?php wp_nav_menu( array('theme_location' => 'primary', 'fallback_cb' => 'appthemes_default_menu', 'container' => false) ); ?>

                <div class="clr"></div>

    
            </div><!-- /header_menu_res -->

        </div><!-- /header_menu -->

    </div><!-- /header -->
           
            <?php appthemes_after_header(); ?>

	        <?php include_once( dirname( __FILE__ ) . '/theme-searchbar.php' ); ?>
