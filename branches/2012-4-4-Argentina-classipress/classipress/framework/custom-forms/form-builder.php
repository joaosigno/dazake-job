<?php

define( 'APP_FORMS_PTYPE', 'custom-form' );

add_action( 'init', 'appthemes_forms_register_post_type' );
add_action( 'save_post', 'appthemes_forms_save' );


function appthemes_forms_register_post_type() {

	register_post_type( APP_FORMS_PTYPE, array(
		'labels' => array(
			'name'               => __( 'Custom Forms', APP_TD ),
			'singular_name'      => __( 'Custom Form', APP_TD ),
			'add_new'            => __( 'Add New', APP_TD ),
			'add_new_item'       => __( 'Add New Custom Form', APP_TD ),
			'edit_item'          => __( 'Edit Form', APP_TD ),
			'new_item'           => __( 'New Form', APP_TD ),
			'view_item'          => __( 'View Forms', APP_TD ),
			'search_items'       => __( 'Search Forms', APP_TD ),
			'not_found'          => __( 'No forms found', APP_TD ),
			'not_found_in_trash' => __( 'No forms found in Trash', APP_TD ),
			'menu_name'          => __( 'Custom Forms', APP_TD )
		),
		'supports'             => array( 'title' ),
		'register_meta_box_cb' => 'appthemes_forms_meta_boxes',
		'hierarchical'         => false,
		'show_ui'              => true,
		'show_in_nav_menus'    => false,
		'publicly_queryable'   => false,
		'exclude_from_search'  => false,
		'has_archive'          => false,
		'query_var'            => false,
		'can_export'           => true,
		'capability_type'      => 'post'
	) );
}

function appthemes_forms_meta_boxes( $post ) {
	wp_enqueue_script( 'form-builder', get_template_directory_uri() . '/framework/custom-forms/form-builder.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), '20110909' );
	wp_localize_script(
		'form-builder',
		'l10n',
		array(
			'save'               => __( 'Save', APP_TD ),
			'add_new_field'      => __( 'Add New Field...', APP_TD ),
			'text'               => __( 'Text Field', APP_TD ),
			'title'              => __( 'Title', APP_TD ),
			'paragraph'          => __( 'Paragraph', APP_TD ),
			'checkboxes'         => __( 'Checkboxes', APP_TD ),
			'radio'              => __( 'Radio', APP_TD ),
			'select'             => __( 'Select List', APP_TD ),
			'text_field'         => __( 'Text Field', APP_TD ),
			'label'              => __( 'Label', APP_TD ),
			'paragraph_field'    => __( 'Paragraph Field', APP_TD ),
			'select_options'     => __( 'Select Options', APP_TD ),
			'add'                => __( 'Add', APP_TD ),
			'checkbox_group'     => __( 'Checkbox Group', APP_TD ),
			'remove_message'     => __( 'Are you sure you want to remove this element?', APP_TD ),
			'remove'             => __( 'Remove', APP_TD ),
			'radio_group'        => __( 'Radio Group', APP_TD ),
			'selections_message' => __( 'Allow Multiple Selections', APP_TD ),
			'hide'               => __( 'Hide', APP_TD ),
			'required'           => __( 'Required', APP_TD ),
			'show'               => __( 'Show', APP_TD ),
		)
	);

	wp_enqueue_style( 'form-builder', get_template_directory_uri() . '/framework/custom-forms/form-builder.css', array(), '20110909' );
	wp_enqueue_style( 'gh-buttons', get_template_directory_uri() . '/framework/custom-forms/gh-buttons.css', array( 'colors' ), '20110911' );

	add_meta_box( 'app-form-builder', __( 'Form Builder', APP_TD ), 'appthemes_forms_meta_box', APP_FORMS_PTYPE, 'normal', 'core' );
}

function appthemes_forms_meta_box( $post ) {
	if ( ! $form = get_post_meta( $post->ID, 'va_form', true ) )
		$form = '[]';
?>
	<script type="text/javascript">
	jQuery( function($) {
		$('#app-form-builder-div').formbuilder();
		$(function() {
			$("#app-form-builder ul").sortable({ opacity: 0.6, cursor: 'move'});
		});
	});
	</script>

	<div id="app-form-builder-div">
		<input type="hidden" name="va_form" id="va_form" value='<?php echo esc_attr( $form ); ?>' />
	</div>

	<?php
}

function appthemes_forms_save( $post_id ) {
	if ( !isset( $_POST['va_form'] ) )
		return;

	parse_str( $_POST['va_form'] );

	foreach ( $va_form as &$field ) {
		if ( 'input_text' == $field['cssClass'] || 'textarea' == $field['cssClass'] )
			$label = $field['values'];
		else
			$label = $field['title'];

		$field['id'] = 'app_' . strtolower( preg_replace( '/[^A-Za-z0-9_]/', '', str_replace( ' ', '-', $label ) ) );
	}

	update_post_meta( $post_id, 'va_form', json_encode( $va_form ) );
}

function appthemes_forms_fields( $form_id ) {
	$form = get_post_meta( $form_id, 'va_form', true );
	if ( ! $form )
		return array();

	$fields = array();

	foreach ( json_decode( $form ) as $field ) {
		$required = ( $field->required == 'checked' ); // TODO

		$args = array(
			'name' => $field->id,
			'type' => $field->cssClass,
		);

		if ( 'input_text' == $args['type'] )
			$args['type'] = 'text';

		switch ( $args['type'] ) {
		case 'select':
		case 'radio':
		case 'checkbox':
			$args['desc'] = $field->title;

			$values = array();
			$checked = array();

			foreach ( $field->values as $option ) {
				$values[] = $option->value;

				if ( $option->baseline == 'checked' )
					$checked[] = $option->value;
			}

			$args['values'] = $values;

			if ( 'checkbox' == $args['type'] )
				$args['default'] = $checked;
			elseif ( !empty( $args['default'] ) )
				$args['default'] = $checked[0];

			break;
		default:
			$args['desc'] = $field->values;
		}

		$args['desc_pos'] = 'before';

		$fields[] = $args;
	}

	return $fields;
}

