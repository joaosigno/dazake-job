<?php
/**
 * Write your own functions or modify functions, actions, and filters using this file.
 * LIST YOUR FUNCTIONS (optional):
 * 
 */

//Place All Your Custom Function Below This Line

//change price to spit out correct looking currency and ignore anything that's not a price.


//add js script 
function my_scripts_method() {

      $dazakejsurl =  get_bloginfo('stylesheet_url');
      $dazakejsurl = str_replace('style.css', 'dazakejs.js',$dazakejsurl);
	wp_enqueue_script(
		'dazakejs',
		$dazakejsurl,
		array('scriptaculous')
	);

}    


add_action('wp_enqueue_scripts', 'my_scripts_method');


//add custom meta box 
/* Define the custom box */
add_action( 'add_meta_boxes', 'myplugin_add_custom_box' );

// backwards compatible (before WP 3.0)
// add_action( 'admin_init', 'myplugin_add_custom_box', 1 );

/* Do something with the data entered */
add_action( 'save_post', 'myplugin_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function myplugin_add_custom_box() {
    add_meta_box( 
        'myplugin_sectionid',
        __( 'Livechat* :', 'appthemes' ),
        'myplugin_inner_custom_box',
        'ad_listing' 
    );
}

/* Prints the box content */
function myplugin_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
  $meta_values = get_post_meta($post->ID, 'myplugin_new_field', true); 
  // The actual fields for data entry
  echo '<label for="myplugin_new_field">';
       _e("Livechat* :", 'appthemes' );
  echo '</label> ';
  echo '<textarea rows="10" cols="30" id="myplugin_new_field" name="myplugin_new_field">';
  echo $meta_values;
  echo '</textarea>';
}

/* When the post is saved, saves our custom data */
function myplugin_save_postdata( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // OK, we're authenticated: we need to find and save the data

  $mydata = $_POST['myplugin_new_field'];

  $mydata = htmlentities($mydata);

  update_post_meta($post_id, 'myplugin_new_field', $mydata);
  // Do something with $mydata 
  // probably using add_post_meta(), update_post_meta(), or 
  // a custom table (see Further Reading section below)
}



// initialize all the sidebars so they are widgetized
function cp_dazake_sidebars_init() {

    if ( !function_exists('register_sidebars') )
        return;

    register_sidebar(array(
        'name'          => __('Head Sidebar','appthemes'),
        'id'            => 'sidebar_dazake_head',
        'description'   => __('This is the head ClassiPress sidebar add by child theme.','appthemes'),
        'before_widget' => '<div class="shadowblock_out" id="%2$s"><div class="shadowblock">',
        'after_widget'  => '</div><!-- /shadowblock --></div><!-- /shadowblock_out -->',
        'before_title'  => '<h2 class="dotted">',
        'after_title'   => '</h2>',
    ));

}

add_action( 'init', 'cp_dazake_sidebars_init' );



