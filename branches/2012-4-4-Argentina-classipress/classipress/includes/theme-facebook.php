<?php
global $current_user, $pagenow; 

// load facebook namespace
function cp_facebook_namespace($output) {
	if ( 'yes' == get_option( 'cp_enable_fb', 'yes' ) )
    	$output .= ' xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"';
	return $output;
}
add_filter('language_attributes', 'cp_facebook_namespace');

 

// load facebook API 
function cp_facebook_api() {
	// don't load any Facebook stuff if Facebook Authentication is disabled
	if ( 'no' == get_option( 'cp_enable_fb', 'yes' ) )
		return;
?>
	<div id="fb-root"></div>
		<script type='text/javascript'>
		//<![CDATA[
		  window.fbAsyncInit = function() {
			FB.init({
			  appId   : '<?php echo esc_js( get_option( 'cp_fb_appid' ) ); ?>',
			  status  : true,
			  cookie  : true, 
			  xfbml   : true 
			});

			// whenever the user logs in, we refresh the page
			FB.Event.subscribe('auth.login', function() {
			  //window.location.reload();
        window.location = "<?php echo site_url( '/'.get_option('cp_dashboard_url').'/' ); ?>";
			});
      
		  };
		  
		  (function() {
			var e = document.createElement('script');
			e.src = document.location.protocol + '//connect.facebook.net/<?php echo get_option( 'cp_fb_lang', 'en_US' ); ?>/all.js';
			e.async = true;
			document.getElementById('fb-root').appendChild(e);
		  }());
		//]]>
		</script>
		
<?php
}
$current_user = wp_get_current_user();
if( ( !is_user_logged_in() && 'wp-login.php' == $pagenow ) || ( is_user_logged_in() && ('fb-' == substr($current_user->user_login, 0, 3)) ) )
  add_action('wp_footer', 'cp_facebook_api');



function cp_facebook_instance() {
	global $facebook, $fb_id, $pagenow;
	
	// don't load any Facebook stuff if Facebook Authentication is not enabled
	if ( 'no' == get_option( 'cp_enable_fb', 'yes' ) )
		return;

	// load facebook platform
	require_once('lib/fb/facebook.php');

	// create our app instance
	$facebook = new Facebook( array (
			  'appId'  => get_option( 'cp_fb_appid' ),
			  'secret' => get_option( 'cp_fb_appsecret' ),
			  'cookie' => true
	));

  // Get FB User ID
	$fb_id = $facebook->getUser();
  
	$fb_user = null;
	
	if (!$fb_id) {
 
		// $url = $facebook->getLoginUrl(array(
		// 'canvas' => 1,
		// 'fbconnect' => 0
		// ));
		 
		//echo "<script type='text/javascript'>top.location.href = '$url';</script>";
	 
	} else {
	  try { // ok we're logged into Facebook

		$fb_user = $facebook->api('/me');

		$user = get_user_by( 'login', "fb-$fb_id" );
		if ( ! $user )
			$user = get_user_by( 'email', $fb_user['email'] );

		if ( ! $user ) {
			$user = array(
				'user_login'      => "fb-$fb_id",
				'user_pass'       => wp_generate_password( 12, false ),
				'nickname'        => $fb_user['first_name'],
				'user_email'      => $fb_user['email'],
				'display_name'    => $fb_user['name'],
				'first_name'      => $fb_user['first_name'],
				'last_name'       => $fb_user['last_name']
			);
			$user_id = wp_insert_user( $user );
		} else {
			$user_id = $user->ID;
		}

		wp_set_current_user( $user_id, "fb-$fb_id" );
		wp_set_auth_cookie( $user_id );
		do_action( 'wp_login', "fb-$fb_id" );
		if ( 'wp-login.php' == $pagenow )
			wp_redirect( site_url( '/'.get_option('cp_dashboard_url').'/' ) );

	  } catch (FacebookApiException $e) {
		error_log($e);
		$fb_id = null;
	  }
	}
}
add_action('init', 'cp_facebook_instance', 20);


// show the login to facebook button if they aren't already logged in
function cp_facebook_login_button() {
	if ( 'no' == get_option( 'cp_enable_fb', 'yes' ) )
		return;

    if ( !is_user_logged_in())
		echo '<p class="facebook"><fb:login-button scope="email">'. __("Login with Facebook", "appthemes") .'</fb:login-button></p>';
}
add_action('login_form', 'cp_facebook_login_button');

?>
