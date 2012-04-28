<?php

	/**
	 * Ladda script
	 */
	function dazake_load_script() {
		if (!is_admin()) {

			/**
			 * Deregister wordpress scripts
			 */
			wp_deregister_script('jquery');

			/**
			 * wp_register_script( $handle, $src, $deps, $ver, $in_footer );
			 */
			wp_register_script('jquery', 'http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js');
			wp_register_script('modernizr', get_template_directory_uri() . '/js/libs/modernizr.js');
			wp_register_script('bootstrap', get_template_directory_uri() . '/js/libs/bootstrap/js/bootstrap.min.js');
			wp_register_script('lazyload', get_template_directory_uri() . '/js/libs/lazyload.js');
			wp_register_script('less', get_template_directory_uri() . '/js/libs/less.js');
			wp_register_script('main', get_template_directory_uri() . '/js/main.js');


			/**
			 * Laddar skripten vi registrerat ovan.
			 */
			wp_enqueue_script('jquery');
			wp_enqueue_script('modernizr');
			wp_enqueue_script('bootstrap');
			wp_enqueue_script('lazyload');
			wp_enqueue_script('less');
			wp_enqueue_script('main');

			/**
			 * load stylesheet
			 */
			wp_enqueue_style( 'style', get_stylesheet_uri() );
			wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/js/libs/bootstrap/css/bootstrap.min.css' );
		}
	}
	add_action('init', 'dazake_load_script');
?>