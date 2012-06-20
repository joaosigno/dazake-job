<?php
/*
Plugin Name: XML-post
Plugin URI: http://bryantchan.com
Description: This plugin generates an XML file for a single post
Author: Bryant Chan
Version: 1.0
Author URI: http://bryantchan.com
*/
session_start();
$id = $_GET['post'];
$post = get_post($id);
$_SESSION['id'] = $id;
$_SESSION['posttitle'] = $post->post_title;
$_SESSION['postlink'] = $post->guid;
$_SESSION['postcontent'] = $post->post_content;
/**
 * Ladda script
 */
function dazake_load_script() {
	if (is_admin()) {

		/**
		 * wp_register_script( $handle, $src, $deps, $ver, $in_footer );
		 */
		wp_register_script('main', plugins_url() . '/post-xml/js/main.js');


		/**
		 * Laddar skripten vi registrerat ovan.
		 */
		wp_enqueue_script('jquery');
		wp_enqueue_script('main');
	}
}
add_action('admin_enqueue_scripts', 'dazake_load_script');

include_once "post-xml.php";

/*** Slideshow ***/

$prefix = 'bryant_';

$meta_box = array(
    'id' => 'export-xml',
    'title' => 'Export Post',
    'page' => 'post',
    'context' => 'side',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Export to XML',
            'id' => 'xmlbutton',
            'type' => 'button'
        )
    )
);
add_action('admin_menu', 'sight_add_box');

// Add meta box
function sight_add_box() {
    global $meta_box;

    add_meta_box($meta_box['id'], $meta_box['title'], 'sight_show_box', $meta_box['page'], $meta_box['context'], $meta_box['priority']);
}

// Callback function to show fields in meta box
function sight_show_box() {
    global $meta_box, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="sight_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
                '<td>';
                echo '<a href="'.plugins_url().'/post-xml/generate.php" ><input type="button"  name="', $field['id'], '" id="', $field['id'], '" value="Export to XML" class="button"/></a>';
        echo '<td>',
            '</tr>';
    }

    echo '</table>';
}

?>