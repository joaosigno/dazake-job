<?php
/*
Plugin Name: Xtreme Carousel
Plugin URI: http://classipro.com/
Description: The best carousel for showing featured ads on your ClassiPress based website.
Version: 1.2
Author: alucas & rubencio
Author URI: http://classipro.com/
License: GPL2
*/

if (!defined('TT'))
	define('TT', plugins_url('/xtremecarousel/timthumb.php'));
	
add_action('wp_head', 'xtremecarousel_header');

function xtremecarousel(){
	global $wpdb, $post;
?>

<?php 
if (is_home())
query_posts( array('post__in' => get_option('sticky_posts'),  'post_type' => APP_POST_TYPE, 'post_status' => 'publish', 'orderby' => 'rand', 'posts_per_page'=>20) );
else if (is_tax()){
	$term  = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
	query_posts( array('post__in' => get_option('sticky_posts'),  'post_type' => APP_POST_TYPE, 'post_status' => 'publish', 'orderby' => 'rand', 'posts_per_page'=>'-1', 'posts_per_page' => 20,'ad_cat'=>$term->slug) );
}

if (have_posts()) : 
?>

<div id="services-example-1" class="theme1">

	<ul>
    <?php while (have_posts()) : the_post(); ?>
	<?php
		$attachment = get_posts(array('post_type' => 'attachment','post_status' => null,'order' => 'ASC','orderby' => 'menu_order','post_mime_type' => 'image','post_parent' => $post->ID));
		
		if ($attachment){
		
			$url_thumb = TT.'?src='.wp_get_attachment_url($attachment[0]->ID, false).'&h=110&w=150';
			$url = TT.'?src='.wp_get_attachment_url($attachment[0]->ID, false).'&h=280&w=498';
			
		}
		else{
		
			$url_thumb = get_bloginfo('template_url') .'/images/no-thumb.jpg';
			$url = TT.'?src='.get_bloginfo('template_url') .'/images/no-thumb.jpg&h=280&w=498&zc=3';
			
		}
	?>
    
    	<!-- SLIDES -->
        <li>
			<img class="thumb" src="<?php echo $url_thumb; ?>" data-bw="<?php echo $url_thumb; ?>">
            <div style="margin-top:16px"></div>
            <a id="rb_title"><?php if ( mb_strlen(get_the_title()) >= 14 ) echo mb_substr( get_the_title(), 0, 14 ).'...'; else the_title(); ?></a>
            <p id="rb_xtrmcarousel">
            	Under: <?php if ( get_the_category() ) the_category(', '); else echo get_the_term_list( $post->ID, APP_TAX_CAT, '', ', ', '' ); ?><br />
            	By: <span class="owner"><?php the_author_posts_link(); ?></span><br />
            	<span class="rb_price">Price: <?php if ( get_post_meta( $post->ID, 'price', true ) ) cp_get_price_legacy($post->ID); else cp_get_price( $post->ID, 'cp_price' ); ?></span>
            </p>
            <a class="buttonlight morebutton" href="#">View More</a>
            
            <!-- EXTRA SHOWN IN "BUTTON" EVENT -->
            <div class="page-more">

            	<a href="<?php the_permalink() ?>">

                <img class="big-image" src="<?php echo $url;  ?>">
                </a>
                <div class="details_double">
<?php
//livechat
$meta_values = get_post_meta($post->ID, 'myplugin_new_field', true); 
if(!empty($meta_values)){
$meta_values = htmlspecialchars_decode($meta_values);
echo '<div class = "dazake_live_chat_page" >';
echo $meta_values;
echo '</div>';
}

?>
                	<h2><a id="rb_title_inside" href="<?php the_permalink() ?>"><?php if ( mb_strlen(get_the_title()) >= 60 ) echo mb_substr( get_the_title(), 0, 60 ).'...'; else the_title(); ?></a></h2>
                    <div class="price-wrap">
                    	<span class="tag-head">&nbsp;</span><p class="post-price"><?php if ( get_post_meta( $post->ID, 'price', true ) ) cp_get_price_legacy($post->ID); else cp_get_price( $post->ID, 'cp_price' ); ?></p>
                    </div>
                    <p id="rb_xtrmcarousel_inside">
                    	Under: <?php if ( get_the_category() ) the_category(', '); else echo get_the_term_list( $post->ID, APP_TAX_CAT, '', ', ', '' ); ?><br />
                        By: <span class="owner"><?php the_author_posts_link(); ?></span><br />
                        On: <?php echo appthemes_date_posted($post->post_date); ?><br />
                    </p>
                    <p id="rb_xtrmcarousel_description">
                    	<?php $tcontent = strip_tags( get_the_content() ); if ( mb_strlen($tcontent) >= 200 ) echo mb_substr( $tcontent, 0, 200 ).'...'; else echo $tcontent; ?>
                    </p>
                    <a class="buttonlight" href="<?php the_permalink() ?>">Go to Ad Details</a>
                </div>
                <div class="closer"></div>
            </div>
        </li>
        
    <?php endwhile; ?>
    </ul>
    
    <!-- TOOLBAR (LEFT/RIGHT) BUTTONS -->
    <div class="toolbar">
    	<div class="left"></div><div class="right"></div>
    </div>
    
    <div class="clr"></div>
</div><!-- services-example-1 -->

<script type="text/javascript">
	jQuery(document).ready(function() {
	jQuery.noConflict();					 									
					
	jQuery('#services-example-1').services(
		{										
			width:900,
			height:290,							
			slideAmount:5,
			slideSpacing:20,							
			touchenabled:"on",
			mouseWheel:"on",
			slideshow:6000,
			callBack:function() { }
		});
	});
</script>                    
                    
<?php
wp_reset_query();
else :
$term  = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
	query_posts( array('post_type' => APP_POST_TYPE, 'post_status' => 'publish', 'orderby' => 'rand', 'posts_per_page'=>'-1', 'ad_cat'=>$term->slug) );

endif;
}
function xtremecarousel_header(){	
	$dir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); 
	echo '<link type="text/css" rel="stylesheet" href="' . $dir .'services-plugin/css/settings.css" />' . "\n";
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js', false, '1.7.1');
	wp_enqueue_script('jquery');
	echo '<script type="text/javascript" src="' . $dir .'services-plugin/js/jquery.easing.1.3.js"></script>' . "\n";
	echo '<script type="text/javascript" src="' . $dir .'services-plugin/js/jquery.cssAnimate.mini.js"></script>' . "\n";
	echo '<script type="text/javascript" src="' . $dir .'services-plugin/js/jquery.touchwipe.min.js"></script>' . "\n";
	echo '<script type="text/javascript" src="' . $dir .'services-plugin/js/jquery.mousewheel.min.js"></script>' . "\n";
	echo '<script type="text/javascript" src="' . $dir .'services-plugin/js/jquery.themepunch.services.js"></script>' . "\n";
}
?>