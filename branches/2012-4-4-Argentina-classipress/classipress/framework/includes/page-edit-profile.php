<?php

class APP_User_Profile extends APP_Page_Template {

	function __construct() {
		parent::__construct( 'edit-profile.php', __( 'Edit Profile', APP_TD ) );
	}

	// Prevent non-logged-in users from accessing the edit-profile.php page
	function template_redirect() {
		appthemes_auth_redirect_login();
	}
}

function appthemes_get_edit_profile_url() {
	if ( $page_id = APP_Page_Template::get_id( 'edit-profile.php' ) )
		return get_permalink( $page_id );

	return get_edit_profile_url( get_current_user_id() );
}

