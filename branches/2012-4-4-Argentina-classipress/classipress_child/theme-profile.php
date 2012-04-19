<?php

/**
 * Add more profile fields to the user
 *
 * Easy to add new fields to the user profile by just
 * creating your new section below and adding a new
 * update_user_meta line
 *
 * @since 3.0.0
 * @uses show_user_profile & edit_user_profile WordPress functions
 *
 * @param int $user User Object
 * @return bool True on successful update, false on failure.
 *
 */

global $appthemes_extended_profile_fields;

$appthemes_extended_profile_fields = array(
	
	/////////Your's extra fields////////////
	'user_type' => array(                            
        'title'=> 'Tipo de cuenta:',
        'type' => 'typedropdown',
        'description' =>  '¿Sos un vendedor individual o broker?'
    ),
	 'user_broker' => array(                            
        'title'=> 'Nombre del Broker o empresa:',
        'type' => 'text',
        'description' =>  'Si sos un Broker ingresá tu nombre o el de tu empresa.'
    ),
    'user_phone' => array(                            
        'title'=> 'Teléfono:',
        'type' => 'text',
        'description' =>  ''
    ),
    'user_state' => array(
        'title'=> 'Provincia:',
        'type' => 'statedropdown',
        'description' =>  ''
    ),
    'user_city' => array(
        'title'=> 'Ciudad:',
        'type' => 'text',
        'description' =>  ''
    ),
    'user_adress' => array(
        'title'=> 'Dirección:',
        'type' => 'text',
        'description' =>  ''
    
    ),
///////////////////////////////////////////////////////
);
$appthemes_extended_profile_fields = apply_filters('appthemes_extended_profile_fields', $appthemes_extended_profile_fields);



// display the additional user profile fields
if (!function_exists('cp_profile_fields')) {
    function cp_profile_fields($user) {
	global $appthemes_extended_profile_fields;
?>
		<h3><?php _e('Extended Profile', 'appthemes'); ?></h3>
        <table class="form-table">

			<?php
			foreach ( $appthemes_extended_profile_fields as $field_id => $field_values ) :

				if ( isset($field_values['protected']) && $field_values['protected'] == 'yes' && !is_admin() )
				    $protected = 'disabled="disabled"';
				else
				    $protected = '';

				//TODO - use this value for display purposes while protecting stored value
				//prepare, modify, or filter the field value based on the field ID
				switch ($field_id):
					case 'active_membership_pack':
						$the_display_value = get_pack(get_the_author_meta( $field_id, $user->ID ),'','pack_name');
						break;
					default:
						$the_display_value = false;
						break;
				endswitch;
				$the_value =  get_the_author_meta( $field_id, $user->ID );

				//begin writing the row and heading
				?>
						<tr id="<?php echo $field_id; ?>_row">
							<th><label for="<?php echo $field_id; ?>"><?php echo esc_html( $field_values['title'] ); ?></label></th>
                            <td>
				<?php
				//print the appropriate profile field based on the type of field
				switch ($field_values['type']):

					case 'date':
				?>
								<input type="text" name="<?php echo $field_id; ?>" id="<?php echo $field_id; ?>" value="<?php esc_attr_e( $the_value ); ?>" class="regular-text" size="35" <?php if(!empty($protected)) echo 'style="display: none;"'; ?> /><br />
								<span class="description" <?php if(!empty($protected)) echo 'style="display: none;"'; ?> ><?php echo $field_values['admin_description']; ?><br /></span>
                <input type="text" name="<?php echo $field_id; ?>_display" id="<?php echo $field_id; ?>" value="<?php esc_attr_e( appthemes_display_date($the_value) ); ?>" class="regular-text" size="35" disabled="disabled" /><br />
								<span class="description"><?php echo $field_values['description']; ?></span>
				<?php
					break;
					
					case 'active_membership_pack':
				?>
								<input type="text" name="<?php echo $field_id; ?>" id="<?php echo $field_id; ?>" value="<?php esc_attr_e( $the_value ); ?>" class="regular-text" size="35" <?php if(!empty($protected)) echo 'style="display: none;"'; ?> /><br />
								<span class="description" <?php if(!empty($protected)) echo 'style="display: none;"'; ?> ><?php echo $field_values['admin_description']; ?><br /></span>
                <input type="text" name="<?php echo $field_id; ?>_display" id="<?php echo $field_id; ?>" value="<?php esc_attr_e( $the_display_value ); ?>" class="regular-text" size="35" disabled="disabled" /><br />
								<span class="description"><?php echo $field_values['description']; ?></span>
				<?php
					break;

					default:
				?>
								<input type="text" name="<?php echo $field_id; ?>" id="<?php echo $field_id; ?>" value="<?php echo esc_attr_e( $the_value ); ?>" class="regular-text" size="35" <?php echo $protected ?> /><br />
								<span class="description"><?php echo $field_values['description']; ?></span>
				<?php
					break;
					
					
					
					
					
					
					
					
					

case 'statedropdown':
                    global $wpdb;
                    $regions = $wpdb->get_var( $wpdb->prepare( "SELECT field_values FROM ". $wpdb->prefix . "cp_ad_fields WHERE field_name = 'cp_state';" ) );
                    if ( $regions ) {

                ?>
                              <select name="<?php echo $field_id; ?>" id="<?php echo $field_id; ?>" >
                                     <option value="">-- <?php _e('Seleccionar', 'appthemes') ?> --</option>
                                          <?php
                                          $options = explode( ',', $regions);

                                          foreach ( $options as $option ) {
                                              
                                          ?>
                                          <option <?php if ($the_value == trim($option)) echo "selected='selected'"; ?> value="<?php esc_attr_e($option); ?>"><?php esc_attr_e($option); ?></option>
                                          <?php
                                          }
                                          ?>
                                </select>
                                <br />
                                <span class="description"><?php echo $field_values['description']; ?></span>
                <?php
                    }
                    break;
					
					case 'typedropdown':
                    global $wpdb;
                    $regions = $wpdb->get_var( $wpdb->prepare( "SELECT field_values FROM ". $wpdb->prefix . "cp_ad_fields WHERE field_name = 'cp_type';" ) );
                    if ( $regions ) {

                ?>
                              <select name="<?php echo $field_id; ?>" id="<?php echo $field_id; ?>" >
                                     <option value="">-- <?php _e('Seleccionar', 'appthemes') ?> --</option>
                                          <?php
                                          $options = explode( ',', $regions);

                                          foreach ( $options as $option ) {
                                              
                                          ?>
                                          <option <?php if ($the_value == trim($option)) echo "selected='selected'"; ?> value="<?php esc_attr_e($option); ?>"><?php esc_attr_e($option); ?></option>
                                          <?php
                                          }
                                          ?>
                                </select>
                                <br />
                                <span class="description"><?php echo $field_values['description']; ?></span>
                <?php
                    }
                    break;









					//close the row
				?>
                    		</td>
						</tr>
                <?php
				endswitch;

			endforeach;
			?>

		</table>

    <?php
    }
}
add_action('show_user_profile', 'cp_profile_fields', 0);
add_action('edit_user_profile', 'cp_profile_fields');


// save the user profile fields
if (!function_exists('cp_profile_fields_save')) {
    function cp_profile_fields_save($user_id) {
    	global $appthemes_extended_profile_fields;

        if ( !current_user_can('edit_user', $user_id) ) return false;

        /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
       	foreach ($appthemes_extended_profile_fields as $field_id => $field_values) :

			switch ( $field_values['type'] ) :
				case 'protected':
					//make sure the user is an admin or has the ability to edits all user accounts
					if ( current_user_can('edit_users') ) update_user_meta( $user_id, $field_id, sanitize_text_field( $_POST[$field_id] ) );
					break;
				default:
					update_user_meta( $user_id, $field_id, sanitize_text_field( $_POST[$field_id] ) );
			endswitch;

		endforeach;

    }
}
add_action('personal_options_update', 'cp_profile_fields_save');
add_action('edit_user_profile_update', 'cp_profile_fields_save');
?>
