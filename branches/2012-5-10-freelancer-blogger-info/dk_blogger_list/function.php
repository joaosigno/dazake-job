<?php 
include_once(dirname(__FILE__) . '/tpl/admin.php');//admin tpl
//add dk_blogger_list option page 
function my_add_pages() {
    add_menu_page(__('Dk_Blogger_Setting'), __('Blogger Option'), 'edit_themes', 'dk_blogger_setting', 'dk_blogger_render', '', 7);
    add_submenu_page('dk_blogger_setting', __('Blogger Setting'), __('Blogger Setting'), 'edit_themes', 'dk_blogger_list_setting', 'dk_blogger_list_setting_render');
}

function dk_blogger_render() {
    global $title;
    dk_blogger_render_tpl();
}

function dk_blogger_list_setting_render() {
    global $title;
    if(!empty($_GET['edite'])){
    	dk_blogger_list_setting_render_edite_tpl();//eite blogger info
    }else{
	dk_blogger_list_setting_render_tpl();//list blogger info
   }
}

add_action('admin_menu', 'my_add_pages');

//style script
function dazake_load_script() {
    if (!is_admin()) {
        /**
         * load stylesheet
         */
        wp_enqueue_style( 'bootstrap', plugins_url( '/css/style.css' , __FILE__ ) );
    }
}
add_action('init', 'dazake_load_script');