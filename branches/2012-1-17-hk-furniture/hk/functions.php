<?php
	// get formatted content
	// add_action( 'init', 'getFormatContent' );
	function getFormatContent($content){
		 $ConentArray = explode("\r", $content);
		 for($k = 0; $k < count($ConentArray); $k++){
		 	echo '<p>'.$ConentArray[$k].'</p>';
		 }
	}
	// for ajax
	function handleSingle($objName){
		// echo 'this is handleSingle';
		query_posts('category_name='.$objName.'&showposts=1');
		while (have_posts()) : the_post();
		    echo "<div class='about_single'>";
		    echo "<div class='about_single_title'>";
			the_title();
			echo "</div>";
			echo "<div class='about_single_content'>";
			the_content();
			echo "</div>";
			echo "</div>";
		endwhile;
	}

	function handleCate($objName){
		query_posts('category_name='.$objName);
		while (have_posts()) : the_post();
			echo "<div class='post_thumb'>";
			the_post_thumbnail(array(100,100) );
			echo "</div>";
			echo "<a class='post_title' href='";
			the_permalink();
			echo "'>";
			the_title();
			echo "</a>";
			echo "<div class='post_content'>";
			the_content('More',true);
			echo "</div>";
			echo "@";
		endwhile;
	}

	add_action('wp_ajax_implement_ajax', 'implement_ajax');
	add_action('wp_ajax_nopriv_implement_ajax', 'implement_ajax');
	
	function implement_ajax() {
		if(isset($_POST['sendData'])){
			switch ($_POST['sendData']['type']) {
				case 'single':
					handleSingle($_POST['sendData']['name']);
					break;
				case 'cate':
					handleCate($_POST['sendData']['name']);
					break;
				default:
					return false;
					break;
			}
			die();
		} // end if
	}

	//enable thumbnails display for post
	add_theme_support('post-thumbnails');

	// register menus
	function register_my_menus() {
	  register_nav_menus(
	    array('header-menu' => __( 'Menu' ) )
	  );
	}
	add_action( 'init', 'register_my_menus' );

	//To add filter by product_category
	add_action( 'restrict_manage_posts', 'my_restrict_manage_posts' );
	function my_restrict_manage_posts() {
		global $typenow;
		$taxonomy = "product_category";
		if( $typenow != "page" && $typenow != "post" ){
			$filters = array($taxonomy);
			foreach ($filters as $tax_slug) {
				$tax_obj = get_taxonomy($tax_slug);
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>Show All $tax_name</option>";
				foreach ($terms as $term) { echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; }
				echo "</select>";
			}
		}
	}

	add_action( 'request', 'my_request' );
	function my_request($request) {

		if (is_admin() && isset($request['post_type']) && $request['post_type']=='product') {
			$request['term'] = get_term($request['type'],'type')->name;
	}
	return $request;
	}

	//To add filter by designers
	add_action( 'restrict_manage_posts', 'my_restrict_manage_posts2' );
	function my_restrict_manage_posts2() {
		global $typenow;
		$taxonomy = "designer_category";
		if( $typenow != "page" && $typenow != "post" ){
			$filters = array($taxonomy);
			foreach ($filters as $tax_slug) {
				$tax_obj = get_taxonomy($tax_slug);
				$tax_name = $tax_obj->labels->name;
				$terms = get_terms($tax_slug);
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>Show All $tax_name</option>";
				foreach ($terms as $term) { echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; }
				echo "</select>";
			}
		}
	}

	add_action( 'request', 'my_request2' );
	function my_request2($request) {

		if (is_admin() && isset($request['post_type']) && $request['post_type']=='product') {
			$request['term'] = get_term($request['type'],'type')->name;
	}
	return $request;
	}

	// Redirect term archives to posts
	add_action( 'template_redirect', 'my_redirect_term_to_post' );

	function my_redirect_term_to_post() {
		global $wp_query;

		if ( is_tax() ) {
			$term = $wp_query->get_queried_object();
			
			if ( $term->taxonomy == 'project_category' ) {
				$post_id = my_get_post_id_by_slug( $term->slug, 'project' );
				
				if ( !empty( $post_id ) )
					$url = get_permalink( $post_id );
			}
		}
	}

	function my_get_post_id_by_slug( $slug, $post_type ) {
		global $wpdb;
		
		$slug = rawurlencode( urldecode( $slug ) );
		$slug = sanitize_title( basename( $slug ) );
		$post_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type = %s", $slug, $post_type ) );
		if ( is_array( $post_id ) )
			return $post_id[0];
		elseif ( !empty( $post_id ) );
			return $post_id;

		return false;
	}
?>