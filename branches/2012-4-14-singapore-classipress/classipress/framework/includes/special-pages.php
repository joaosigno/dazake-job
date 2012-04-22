<?php

/**
 * Helper class for defining full-page controllers.
 *
 * Supported methods:
 *  - parse_query() - for correcting query flags
 *  - the_posts(), posts_clauses(), posts_request() for various other manipulations
 *  - template_redirect() - for enqueuing scripts etc.
 *  - template_include( $path ) - for loading a different template file
 *  - title_parts( $parts ) - for changing the title
 */
abstract class APP_Page_Controller {

	/**
	 * Test if this controller should handle the current page.
	 *
	 * Use is_*() conditional tags and get_query_var()
	 *
	 * @return bool
	 */
	abstract function condition();


	function __construct() {
		if ( method_exists( $this, 'init' ) )
			add_action( 'init', array( $this, 'init' ) );

		foreach ( array( 'parse_query' ) as $method ) {
			if ( method_exists( $this, $method ) )
				add_action( $method, array( $this, '_action' ) );
		}

		foreach ( array( 'the_posts', 'posts_clauses', 'posts_request' ) as $method ) {
			if ( method_exists( $this, $method ) )
				add_filter( $method, array( $this, '_filter' ), 10, 2 );
		}

		add_filter( 'template_redirect', array( $this, '_template_redirect' ) );
	}

	final function _action( $wp_query ) {
		if ( !$wp_query->is_main_query() || !$this->condition() )
			return;

		$method = current_filter();

		$this->$method( $wp_query );
	}

	final function _filter( $value, $wp_query ) {
		if ( !$wp_query->is_main_query() || !$this->condition() )
			return $value;

		$method = current_filter();

		return $this->$method( $value, $wp_query );
	}

	final function _template_redirect() {
		if ( !$this->condition() )
			return;

		if ( method_exists( $this, 'template_redirect' ) )
			$this->template_redirect();

		if ( method_exists( $this, 'template_include' ) )
			add_filter( 'template_include', array( $this, 'template_include' ) );

		if ( method_exists( $this, 'title_parts' ) )
			add_filter( 'appthemes_title_parts', array( $this, 'title_parts' ) );
	}
}


/**
 * Class for handling special pages that have a specific template file.
 */
class APP_Page_Template extends APP_Page_Controller {

	private $template;
	private $default_title;

	private static $instances = array();
	private static $page_ids = array();

	static function get_id( $template ) {
		if ( isset( self::$page_ids[$template] ) )
			return self::$page_ids[$template];

		// don't use 'fields' => 'ids' because it skips caching
		$pages = get_posts( array(
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => $template,
			'posts_per_page' => 1
		) );

		if ( empty( $pages ) )
			$page_id = 0;
		else
			$page_id = $pages[0]->ID;

		self::$page_ids[$template] = $page_id;

		return $page_id;
	}

	static function install() {
		foreach ( self::$instances as $template => $instance ) {
			if ( self::get_id( $template ) )
				continue;

			$page_id = wp_insert_post( array(
				'post_type' => 'page',
				'post_status' => 'publish',
				'post_title' => $instance->default_title
			) );

			add_post_meta( $page_id, '_wp_page_template', $template );
		}
	}

	function __construct( $template, $default_title ) {
		$this->template = $template;
		$this->default_title = $default_title;

		self::$instances[$template] = $this;

		parent::__construct();
	}

	function condition() {
		return is_page_template( $this->template );
	}
}

add_action( 'appthemes_first_run', array( 'APP_Page_Template', 'install' ) );

