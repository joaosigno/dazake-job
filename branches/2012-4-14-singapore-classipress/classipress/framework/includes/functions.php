<?php

define( 'APP_TD', 'appthemes' );

/**
 * Loads the appropriate .mo file from wp-content/themes-lang
 */
function appthemes_load_textdomain() {
	$locale = apply_filters( 'theme_locale', get_locale(), APP_TD );

	$base = basename( get_template_directory() );

	load_textdomain( APP_TD, WP_LANG_DIR . "/themes/$base-$locale.mo" );
}

/**
 * A version of load_template() with support for passing arbitrary values.
 *
 * @param string|array Template name(s) to pass to locate_template()
 * @param array Additional data
 */
function appthemes_load_template( $templates, $data = array() ) {
	$located = locate_template( $templates );
	if ( !$located )
		return;

	global $posts, $post, $wp_query, $wp_rewrite, $wpdb, $comment;

	extract( $data, EXTR_SKIP );

	if ( is_array( $wp_query->query_vars ) )
		extract( $wp_query->query_vars, EXTR_SKIP );

	require $located;
}

/**
 * Checks if a user is logged in, if not redirect them to the login page.
 */
function appthemes_auth_redirect_login() {
	if ( !is_user_logged_in() ) {
		nocache_headers();
		wp_redirect( get_bloginfo( 'wpurl' ) . '/wp-login.php?redirect_to=' . urlencode( $_SERVER['REQUEST_URI'] ) );
		exit();
	}
}

/**
 * Sets the favicon to the default location.
 */
function appthemes_favicon() {
	$uri = appthemes_locate_template_uri( 'images/favicon.ico' );

	if ( !$uri )
		return;

?>
<link rel="shortcut icon" href="<?php echo $uri; ?>" />
<?php
}

/**
 * Generates a better title tag than wp_title().
 */
function appthemes_title_tag( $title ) {
	global $page, $paged;

	$parts = array();

	if ( !empty( $title ) )
		$parts[] = $title;

	if ( is_home() || is_front_page() ) {
		$blog_title = get_bloginfo( 'name' );

		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && !is_paged() )
			$blog_title .= ' - ' . $site_description;

		$parts[] = $blog_title;
	}

	if ( !is_404() && ( $paged >= 2 || $page >= 2 ) )
		$parts[] = sprintf( __( 'Page %s', APP_TD ), max( $paged, $page ) );

	$parts = apply_filters( 'appthemes_title_parts', $parts );

	return implode( " - ", $parts );
}

/**
 * Generates a login form that goes in the admin bar.
 */
function appthemes_admin_bar_login_form( $wp_admin_bar ) {
	if ( is_user_logged_in() )
		return;

	$form = wp_login_form( array(
		'form_id' => 'adminloginform',
		'echo' => false,
		'value_remember' => true
	) );

	$wp_admin_bar->add_menu( array(
		'id'     => 'login',
		'title'  => $form,
	) );

	$wp_admin_bar->add_menu( array(
		'id'     => 'lostpassword',
		'title'  => __( 'Lost password?', APP_TD ),
		'href' => wp_lostpassword_url()
	) );

	if ( get_option( 'users_can_register' ) ) {
		$wp_admin_bar->add_menu( array(
			'id'     => 'register',
			'title'  => __( 'Register', APP_TD ),
			'href' => site_url( 'wp-login.php?action=register', 'login' )
		) );
	}
}

/**
 * Generates pagination links.
 */
function appthemes_pagenavi( $wp_query = null, $query_var = 'paged' ) {
	if ( is_null( $wp_query ) )
		$wp_query = $GLOBALS['wp_query'];

	if ( is_object( $wp_query ) ) {
		$params = array(
			'total' => $wp_query->max_num_pages,
			'current' => $wp_query->get( $query_var )
		);
	} else {
		$params = $wp_query;
	}

	$big = 999999999;
	$base = str_replace( $big, '%#%', get_pagenum_link( $big ) );

	echo paginate_links( array(
		'base' => $base,
		'format' => '?' . $query_var . '=%#%',
		'current' => max( 1, $params['current'] ),
		'total' => $params['total']
	) );
}

/**
 * See http://core.trac.wordpress.org/attachment/ticket/18302/18302.2.2.patch
 */
function appthemes_locate_template_uri( $template_names ) {
	$located = '';
	foreach ( (array) $template_names as $template_name ) {
		if ( !$template_name )
			continue;
		if ( file_exists(get_stylesheet_directory() . '/' . $template_name)) {
			$located = get_stylesheet_directory_uri() . '/' . $template_name;
			break;
		} else if ( file_exists(get_template_directory() . '/' . $template_name) ) {
			$located = get_template_directory_uri() . '/' . $template_name;
			break;
		}
	}

	return $located;
}

/**
 * Simple wrapper for adding straight rewrite rules,
 * but with the matched rule as an associative array.
 *
 * @see http://core.trac.wordpress.org/ticket/16840
 *
 * @param string $regex The rewrite regex
 * @param array $args The mapped args
 * @param string $position Where to stick this rule in the rules array. Can be 'top' or 'bottom'
 */
function appthemes_add_rewrite_rule( $regex, $args, $position = 'top' ) {
	add_rewrite_rule( $regex, add_query_arg( $args, 'index.php' ), $position );
}

/**
 * Utility to create an auto-draft post, to be used on front-end forms.
 *
 * @param string $post_type
 * @return object
 */
function appthemes_get_draft_post( $post_type ) {
	$key = 'draft_' . $post_type . '_id';

	$draft_post_id = (int) get_user_option( $key );

	if ( $draft_post_id ) {
		$draft = get_post( $draft_post_id );

		if ( !empty( $draft ) && $draft->post_status == 'auto-draft' )
			return $draft;
	}

	require ABSPATH . '/wp-admin/includes/post.php';

	$draft = get_default_post_to_edit( $post_type, true );

	update_user_option( get_current_user_id(), $key, $draft->ID );

	return $draft;
}

