<?php
/**
 * Main loop for displaying ads
 *
 * @package ClassiPress
 * @author AppThemes
 *
 */
?>
<?php if (is_home()){
}
else
{?>

<div class="pack"></div>



  <div id="loop" class="flip clear">
  

	<?php  $cnt = 1; ?>

	<?php } ?>

	<?php appthemes_before_loop(); ?>

	<?php if ( have_posts() ) : ?>

	    <?php while ( have_posts() ) : the_post(); ?>

	        <?php appthemes_before_post(); ?>
			
			<?php
				$display = '<div class="post-block-out">';
				global $displaytype ;
				if(isset($displaytype)){
					switch ($displaytype) {
						case 'feature':
							if(is_sticky($post_ID) == true)
								$display = '<div class="post-block-out">';
							else
								$display = '<div class="hide">';
						break;
						case 'premium':
							if((!is_sticky($post_ID) == true ) && dazake_is_premiun($post->ID))
								$display = '<div class="post-block-out">';
							else
								$display = '<div class="hide">';
						break;
						case 'free':
							if(dazake_is_free($post->ID))
								$display = '<div class="post-block-out">';
							else
								$display = '<div class="hide">';
						break;
						case 'all':
							$display = '<div class="post-block-out">';
						break;
		
						default:
							$display = '<div class="hide">';
						break;
					}
				}
				echo $display;
			
			?>
	      

	            <div class="<?php if( is_sticky($post_ID) == true) echo 'post-block-featured'; elseif(dazake_is_premiun($post->ID)) echo 'post-block-premium';else echo 'post-block-free';?>">

	                <div class="post-left">
                    
                    <?php 
									
					if ($_COOKIE['mode'] == 'changegrid')
					{
					
					// echo $_COOKIE['mode'];

	
					 ?> 
                    
	                 <?php if ( get_option('cp_ad_images') == 'yes' ) cp_ad_loop_thumbnail(); ?>
	                  </div>

	                    <div class="<?php if ( get_option('cp_ad_images') == 'yes' ) echo 'post-right'; else echo 'post-right-no-img'; ?> <?php echo get_option('cp_ad_right_class'); ?>">

	                   

	                    </div>
	                    <h3><a href="<?php the_permalink(); ?>"><?php if ( mb_strlen( get_the_title() ) >= 60 ) echo mb_substr( get_the_title(), 0, 60 ).'...'; else the_title(); ?></a></h3>
                         <div class="price-wrap">

						<?php if(is_sticky()) {?>

						<span class="tag-head"></span><p class="post-price"><?php if ( get_post_meta( $post->ID, 'price', true ) ) cp_get_price_legacy( $post->ID ); else cp_get_price( $post->ID, 'cp_price' ); ?></p>

						<?php } else { ?>

						<span class="tag-head"></span><p class="post-price-sticky"><?php if ( get_post_meta( $post->ID, 'price', true ) ) cp_get_price_legacy( $post->ID ); else cp_get_price( $post->ID, 'cp_price' ); ?></p>

						<?php } ?>

	                    <div class="clr"></div>
          
           
            <p class="post-meta"><span class="folder"><?php if ( get_the_category() ) the_category(', '); else echo get_the_term_list( $post->ID, APP_TAX_CAT, '', ', ', '' ); ?></span>&nbsp;<span class="owner"><?php if ( get_option('cp_ad_gravatar_thumb') == 'yes' ) appthemes_get_profile_pic( get_the_author_meta('ID'), get_the_author_meta('user_email'), 16 ) ?><?php the_author_posts_link(); ?></span>&nbsp;<span class="clock"><span><?php echo appthemes_date_posted($post->post_date); ?></span></span></p>
           
        
                        
	                    <div class="clr"></div>

	                    <?php appthemes_before_post_content(); ?>

	                    <p class="post-desc"><?php $tcontent = strip_tags( get_the_content() ); if ( mb_strlen( $tcontent ) >= 140 ) echo mb_substr( $tcontent, 0, 140 ).'...'; else echo $tcontent; ?></p>

	                    <?php appthemes_after_post_content(); ?>

	                    <div class="clr"></div>

	                </div>


  <?php } else {
  
  					// echo $_COOKIE['mode'];
					
				
  
  ?>
  <?php 
	if ( get_option('cp_ad_images') == 'yes' ) {
		cp_ad_loop_thumbnail(); 
	}
  ?>
                </div>
        
                <div class="<?php if ( get_option('cp_ad_images') == 'yes' ) echo 'post-right'; else echo 'post-right-no-img'; ?> <?php echo get_option('cp_ad_right_class'); ?>">
                
                    <?php appthemes_before_post_title(); ?>
        
                    <h3><a href="<?php the_permalink(); ?>"><?php if ( mb_strlen(get_the_title()) >= 67) echo mb_substr( get_the_title(), 0, 67 ).'...'; else the_title(); ?></a></h3>
                    
                    <div class="clr"></div>
                    <?php appthemes_after_post_title(); ?>
                    <div class="clr"></div>
                    <?php appthemes_before_post_content(); ?>
        
                    <p class="post-desc"><?php $tcontent = strip_tags( get_the_content() ); if ( mb_strlen( $tcontent ) >= 150 ) echo mb_substr( $tcontent, 0, 150 ).'...'; else echo $tcontent; ?></p>
                    <?php appthemes_after_post_content(); ?>
                    
                    <div class="clr"></div>
        
                </div>

<?php } ?>

	                <div class="clr"></div>

	            </div><!-- /post-block -->

	        </div><!-- /post-block-out -->

	        <?php appthemes_after_post(); ?>

	        <?php if( $cnt % 3 == 0 ) echo '<div class="clr"></div>';$cnt ++;?>

	    <?php endwhile; ?>

	    <?php if (is_home()) {}

		  else {?>

		</div><!-- /loop -->

         <?php } ?>

	    <div class="clr"></div>

	    <?php 
			//only display when the last loop
			global $displaytype ;
			if($displaytype == 'free' || $displaytype == 'all')
			appthemes_after_endwhile(); 
		?>

	    <?php else: ?>

	    <?php 
			//only display when the last loop
			global $displaytype ;
			if($displaytype == 'free' || $displaytype == 'all')
				appthemes_loop_else(); 
		?>

	    </div>

	  <?php endif; ?>

	<?php appthemes_after_loop(); ?>

<?php wp_reset_query(); ?>