<?php
/**
 * Write your own functions or modify functions, actions, and filters using this file.
 * LIST YOUR FUNCTIONS (optional):
 * cp_import_wp_childstyle() [CUSTOM]
 * cp_get_price() [OVERWRITE]
 */

//Place All Your Custom Function Below This Line

//change price to spit out correct looking currency and ignore anything that's not a price.
function cp_get_price($postid) {
	if(get_post_meta($postid, 'cp_price', true)) {
		$price_out = get_post_meta($postid, 'cp_price', true);

		// uncomment the line below to change price format
		$price_out =  ereg_replace("[^0-9.]", "", $price_out);
		$price_out = number_format($price_out, 0, '.', ',');
		$price_out = cp_pos_currency($price_out);
	} else {
		if( get_option('cp_force_zeroprice') == 'yes' )
			$price_out = cp_pos_currency(0);
		else
			$price_out = '&nbsp;';
	}
	echo $price_out;
}

 






function set_author_post_type($query) {

    //$post_type = ad_listing;

    if ($query->is_author) {

        $query->query_vars['post_type']      = 'ad_listing' . $post_type;

        $query->query_vars['posts_per_page'] = 10;

        return $query;

    }

}

add_action('pre_get_posts', 'set_author_post_type');  










function pt_fields_defaults($field_name,$user) {
  if ($user->ID){ 
    switch($field_name){
    case 'cp_city':
        if ($user->user_city) return $user->user_city;
    break;
    case 'cp_street':
        if ($user->user_adress) return $user->user_adress;
    break;
    case 'cp_office':
        if ($user->user_office) return $user->user_office;
    break;
    case 'cp_state':
        if ($user->user_state) return $user->user_state;
    break;   
  
    }
  }
}

//Do not place any code below this line.
?>