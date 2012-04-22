<?php

/**
 * Write your own functions or modify functions, actions, and filters using this file.
 * LIST YOUR FUNCTIONS (optional):
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
add_action( 'add_meta_boxes', 'myplugin_add_custom_box' );
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
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

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
}

// initialize all the sidebars so they are widgetized
function cp_dazake_sidebars_init() {
    if ( !function_exists('register_sidebars') )
        return;
   

}

add_action( 'wp_register_sidebar_widget', 'cp_dazake_sidebars_init' );

//add submenu for adding local live chat
function cp_live_chat(){
  echo 'livechat';
}
// add_submenu_page( 'users.php', __('Live Chat','appthemes'), __('Live Chat','appthemes'), 'manage_options', 'live_chat', 'cp_live_chat' );

add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
  add_submenu_page( 'users.php', 'Live Chat', 'Live Chat', 'manage_options', 'live_chat', 'live_chat_callback' ); 
}

function live_chat_callback() {
  if(isset($_POST['submit'])){
      $mydata = $_POST['locallivechat'];
      update_option( 'locallivechat', $mydata );
  }
  $locallivechat = get_option('locallivechat');
  $locallivechat = stripslashes($locallivechat);
  ?>
  <div class="icon32" id="icon-tools"><br></div>
  <h2>Local Live Chat Setting</h2>
  <form action="?page=live_chat" method = "POST">
    <p class="submit btop" >
    <input type="submit" name = 'submit' value = "Save Changes">
  </p>
    <textarea style = "margin-top:20px" rows="10" cols="30" id="locallivechat" name="locallivechat"><?php echo $locallivechat ; ?></textarea>
  </form>
  <?php
}
