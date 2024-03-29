<?php
/**
 * @package WordPress
 * @subpackage ClassiPress
 * 
 */
      
      
// Do not delete these lines
if ( !empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
        die ( __('Please do not load this page directly.', 'appthemes') );

if ( post_password_required() ) { ?>

        <p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','appthemes'); ?></p>
<?php
        return;
}

global $commentDivsExist;
?>


<?php appthemes_before_blog_comments(); ?>

<?php if ( have_comments() ) : ?>

    <?php $commentDivsExist = true; ?>

    <div class="shadowblock_out start">

        <div class="shadowblock">

            <div id="comments">

                <div id="comments_wrap">
            
                    <h2 class="dotted"><?php comments_number(__('No Responses','appthemes'), __('One Response','appthemes'), __('% Responses','appthemes') );?> <?php _e('to','appthemes'); ?> <span class="colour">&#8220;<?php the_title(); ?>&#8221;</span></h2>

                    <ol class="commentlist">

                        <?php appthemes_list_blog_comments(); ?>

                    </ol>

                    <div class="navigation">

                        <div class="alignleft"><?php previous_comments_link('&laquo; ' . __('Older Comments', 'appthemes'), 0) ?></div>

                        <div class="alignright"><?php next_comments_link(__('Newer Comments', 'appthemes') . ' &raquo;', 0) ?></div>

                        <div class="clr"></div>

                    </div><!-- /navigation -->

                    <div class="clr"></div>
                    
                    <?php appthemes_before_blog_pings(); ?>

                    <?php $carray = separate_comments( $comments ); // get the comments array to check for pings ?>
                    
                    <?php if ( !empty( $carray['pings'] ) ) : // pings include pingbacks & trackbacks ?>

                        <h2 class="dotted" id="pings"><?php _e('Trackbacks/Pingbacks', 'appthemes'); ?></h2>

                        <ol class="pinglist">

                            <?php appthemes_list_blog_pings(); ?>

                        </ol>

                    <?php endif; ?>
                    
                    <?php appthemes_after_blog_pings(); ?>
                    

<?php endif; // have_comments ?>


                    <?php appthemes_after_blog_comments(); ?>
                    
                    <?php appthemes_before_blog_respond(); ?>
                    
                                
                    <?php if ( 'open' == $post->comment_status ) : ?>
                                    
                        <?php appthemes_before_blog_comments_form(); ?>
                                
                        <?php appthemes_blog_comments_form(); ?>
                                            
                        <?php appthemes_after_blog_comments_form(); ?>               
                    
                    <?php endif; // open ?>
                    
                    
                    <?php appthemes_after_blog_respond(); ?>
        
                    
        <?php if ( $commentDivsExist ) : ?>

            </div> <!-- /comments_wrap -->

        </div><!-- /comments -->

    </div><!-- /shadowblock -->

</div><!-- /shadowblock_out -->

<?php endif; ?>