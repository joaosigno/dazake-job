<?php
/**
 * Write your own functions or modify functions, actions, and filters using this file.
 * LIST YOUR FUNCTIONS (optional):
 * 
 */

//Place All Your Custom Function Below This Line

//change price to spit out correct looking currency and ignore anything that's not a price.

function my_scripts_method() {
	wp_enqueue_script(
		'dazakejs',
		plugins_url('/js/dazakejs.js', __FILE__),
		array('scriptaculous')
	);
}    
 
add_action('wp_enqueue_scripts', 'my_scripts_method');