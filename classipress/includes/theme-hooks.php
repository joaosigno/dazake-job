<?php
/**
 * Reserved for any theme-specific hooks
 * For general AppThemes hooks, see appthemes-hooks.php
 *
 * @since 3.1
 * @uses add_action() calls to trigger the hooks.
 *
 */


/** 
 * called in gateway.php to process the payment
 *
 * @since 3.1
 * @param array $order_vals
 *
 */ 
function cp_action_gateway( $order_vals ) { 
	do_action( 'cp_action_gateway', $order_vals ); 
}

 
/** 
 * called in step2.php to hook into the payment dropdown
 *
 * @since 3.1
 *
 */ 
function cp_action_payment_method() {
    do_action( 'cp_action_payment_method' ); 
}


/** 
 * called in admin-gateway-values.php to hook into the admin gateway options
 *
 * @since 3.1
 *
 */ 
function cp_action_gateway_values() {
    do_action( 'cp_action_gateway_values' ); 
}


/** 
 * called in tpl-add-new-confirm.php before update to hook into the confirmation page
 *
 * @since 3.1
 *
 */ 
function cp_add_new_confirm_before_update() {
    do_action( 'cp_add_new_confirm_before_update' ); 
}


/** 
 * called in tpl-add-new-confirm.php after update to hook into the confirmation page
 *
 * @since 3.1
 *
 */ 
function cp_add_new_confirm_after_update() {
    do_action( 'cp_add_new_confirm_after_update' ); 
}


/** 
 * called in process.php to hook into db transaction process
 *
 * @since 3.1
 *
 */ 
function cp_process_transaction_entry() {
    do_action( 'cp_process_transaction_entry' ); 
}



?>