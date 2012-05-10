<?php
/**
 * Hanldes the editprofile shortcode
 *
 * @author Tareq Hasan
 */

function dk_profile_book() {
	// if(empty($_GET['added'])){
		switch ($_GET['dkaction']) {
			case 'manage':
				require_once dirname(__FILE__) . '/functions/manage_book_fun.php';
				require_once dirname(__FILE__) . '/templates/manage_book_tpl.php';
				break;
			case 'edite':
				# code...
				require_once dirname(__FILE__) . '/functions/edite_book_fun.php';
				break;
			case 'library':
				# code...
				require_once dirname(__FILE__) . '/functions/library_book_fun.php';
				break;	
			case 'show':
				# code...
				require_once dirname(__FILE__) . '/functions/show_book_fun.php';
				break;	
			case 'view':
				# code...
				require_once dirname(__FILE__) . '/functions/view_book_fun.php';
				break;	
				break;	
			case 'add':
				# code...
				require_once dirname(__FILE__) . '/functions/add_book_fun.php';
				require_once dirname(__FILE__) . '/templates/add_book_tpl.php';
				break;	
			default:
				require_once dirname(__FILE__) . '/functions/manage_book_fun.php';
				require_once dirname(__FILE__) . '/templates/manage_book_tpl.php';
				break;
		}
	// }
}

add_shortcode( 'dk_profile_book', 'dk_profile_book' );

function dazake_load_script() {
	if (!is_admin()) {
		/**
		 * load stylesheet
		 */
		wp_enqueue_style( 'bootstrap', plugins_url( 'dk_books/css/style.css' , dirname(__FILE__) ) );
	}
}
add_action('init', 'dazake_load_script');

?>