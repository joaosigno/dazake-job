<?php
/**
 * Loop for displaying most popular ads
 *
 * @package ClassiPress
 * @author AppThemes
 *
 */

  global $pageposts;
  $pageposts = cp_get_popular_ads();
?>

<?php appthemes_before_loop(); ?>

<?php if ( $pageposts ) : ?>

    <?php foreach ( $pageposts as $post ) : ?>

      <?php setup_postdata( $post ); ?>

      <?php appthemes_before_post(); ?>
    
	    <div class="post-block-out">

		      <div class="post-block">

			      <div class="post-left">

				<?php if ( get_option('cp_ad_images') == 'yes' ) cp_ad_loop_thumbnail(); ?>

			      </div>

			      <div class="<?php if(get_option('cp_ad_images') == 'yes') echo 'post-right'; else echo 'post-right-no-img'; ?> <?php echo get_option('cp_ad_right_class'); ?>">



				    <?php appthemes_before_post_title(); ?>
<?php
//livechat
$meta_values = get_post_meta($post->ID, 'myplugin_new_field', true); 
if(!empty($meta_values)){
$meta_values = htmlspecialchars_decode($meta_values);
echo '<div class = "dazake_live_chat" >';
echo $meta_values;
echo '</div>';
}

?>
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

      <?php appthemes_after_post(); ?>

    <?php endforeach; ?>

    <?php appthemes_after_endwhile(); ?>

<?php else: ?>

    <?php appthemes_loop_else(); ?>

<?php endif; ?>

<?php appthemes_after_loop(); ?>

<?php wp_reset_query(); ?>
