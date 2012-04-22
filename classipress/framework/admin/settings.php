<?php

abstract class APP_Tabs_Page extends scbAdminPage {

	protected $tabs;
	protected $tab_sections;

	function form_handler() {
		if ( empty( $_POST['action'] ) || !isset( $this->tabs[ $_POST['action'] ] ) )
			return;

		check_admin_referer( $this->nonce );

		$form_fields = array();

		foreach ( $this->tab_sections[ $_POST['action'] ] as $section )
			$form_fields = array_merge( $form_fields, $section['fields'] );

		$to_update = scbForms::validate_post_data( $form_fields, $this->options->get() );

		$this->options->update( $to_update );

		$this->admin_msg();
	}

	function page_content() {
		if ( isset( $_GET['firstrun'] ) )
			do_action( 'appthemes_first_run' );

		$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';

		if ( !isset( $this->tabs[ $active_tab ] ) )
			$active_tab = key( $this->tabs );

		$current_url = scbUtil::get_current_url();

		echo '<h3 class="nav-tab-wrapper">';
		foreach ( $this->tabs as $tab_id => $tab_title ) {
			$class = 'nav-tab';

			if ( $tab_id == $active_tab )
				$class .= ' nav-tab-active';

			$href = add_query_arg( 'tab', $tab_id, $current_url );

			echo ' ' . html( 'a', compact( 'class', 'href' ), $tab_title );
		}
		echo '</h3>';

		echo '<form method="post" action="">';
		echo '<input type="hidden" name="action" value="' . $active_tab . '" />';
		wp_nonce_field( $this->nonce );

		foreach ( $this->tab_sections[ $active_tab ] as $section ) {
			echo html( 'h3', $section['title'] );
			echo $this->table( $section['fields'] );
		}

		echo '<p class="submit"><input type="submit" class="button-primary" value="' . esc_attr__( 'Save Changes', APP_TD ) . '" /></p>';
		echo '</form>';
	}
}

