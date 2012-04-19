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
 * Generates a better title tag than wp_title()
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
 * Generates pagination links
 */
function appthemes_pagenavi() {
	global $wp_query;

	$big = 999999999;

	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var( 'paged' ) ),
		'total' => $wp_query->max_num_pages
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


