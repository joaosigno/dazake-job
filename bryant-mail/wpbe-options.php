<div class="wrap">
	<h2><?php _e('Email settings', 'wp-better-emails'); ?></h2>

	<form method="post" action="options.php" id="wpbe_options_form">
		<?php settings_fields('wpbe_full_options'); ?>
		
		<!-- Sender options -->
		<p style="margin-bottom: 0;"><?php _e('Set your own sender name and email address. Default Wordpress values will be used if empty.', 'wp-better-emails'); ?></p>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="wpbe_from_name"><?php _e('Name', 'wp-better-emails'); ?></label></th>
				<td><input type="text" id="wpbe_from_name" class="regular-text" name="wpbe_options[from_name]" value="<?php esc_attr_e($this->options['from_name']); ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="wpbe_from_email"><?php _e('Email address', 'wp-better-emails'); ?></label></th>
				<td><input type="text" id="wpbe_from_email" class="regular-text" name="wpbe_options[from_email]" value="<?php echo esc_attr_e($this->options['from_email']); ?>" /></td>
			</tr>
		</table>
		
		<!-- Template -->
		<h3 class="wpbe_title"><?php _e('HTML Template', 'wp-better-emails'); ?>
		<?php if( version_compare($wp_version, '3.1', '>') ): ?>
			<a class="thickbox button" title="<?php esc_attr_e('Live template preview', 'wp-better-emails'); ?>" id="wpbe_preview_template" href="<?php echo plugins_url('preview.html?keepThis=true&TB_iframe=true&height=400&width=700', __FILE__); ?>"><?php _e('Live preview', 'wp-better-emails'); ?></a>
		<?php endif; ?>
		</h3>
		<p><?php _e('Edit the HTML email template if you want to customize it. You might have a look at the <a href="#" id="wpbe_help">help tab</a> for further information.', 'wp-better-emails'); ?></p>
		<div id="wpbe_template_container">
			<?php $this->template_editor() ?>
		</div>
		
		
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'wp-better-emails') ?>" />
		</p>
	</form>

	<!-- for group user dazake -->
	<?php
		function get_groups(){
			global $wpdb;
			$groups = $wpdb->get_results( $wpdb->prepare("SELECT LABEL FROM wp_cimy_uef_fields") );
			$groups = $groups[0]->LABEL;
			$groups =  explode(",", $groups);

			return $groups;
		}

		$user_groups = get_groups();
	?>
		<h3>Select User Group</h3>
		<select name="ztem-user-group" id="ztem-user-group">
			<option value="Select a group">Select a group</option>
			<?php
			  for($i=0; $i<count($user_groups); $i++){
			  echo 	'<option value="'.$user_groups[$i].'">'.$user_groups[$i].'</option>';
			  }
			?>
		</select>
	<?php
	?>


	<!-- for group user dazake -->

	<!-- test -->
	<div id="maillist">
	  <form name="form_eemail" method="post" action="admin.php?page=add_admin_menu_email_to_registered_user" onsubmit="return send_email_submit()"  >
	    <input type="hidden" name="send" value="true" />
	    <!-- <input type="button" name="CheckAll" value="Check All" onClick="SetAllCheckBoxes('form_eemail', 'eemail_checked[]', true);"> -->
	    <!-- <input type="button" name="UnCheckAll" value="Uncheck All" onClick="SetAllCheckBoxes('form_eemail', 'eemail_checked[]', false);"> -->
	    <?php
	global $wpdb, $wp_version;
	$data = $wpdb->get_results("select ID,user_nicename,user_email from ". $wpdb->prefix . "users ORDER BY user_nicename");

	//edited by bryant get group by id;
	function get_group_by_id($id){
		global $wpdb;
		$group = $wpdb->get_results( $wpdb->prepare("SELECT VALUE FROM wp_cimy_uef_data WHERE ID like $id") );
		return $group[0]->VALUE;
	};
	//edited by bryant get group by id;
	
	if ( !empty($data) ) 
	{
	echo "<table border='0' style='padding:4px;'><tr>";
	$col=3;
	$count = 0;
	foreach ( $data as $data )
	{
		$to = $data->user_email;
		$id = $data->ID;
		$group = get_group_by_id($id);
		if($to <> "")
		{
			echo "<td>";
			?>
	    <input class="radio <?php echo $group ;?>" type="checkbox" value='<?php echo $to; ?>' name="eemail_checked[]">
	    &nbsp;<?php echo $to; ?>
	    <?php
			if($col > 1) 
			{
				$col=$col-1;
				echo "</td><td>"; 
			}
			elseif($col = 1)
			{
				$col=$col-1;
				echo "</td></tr><tr>";;
				$col=3;
			}
			$count = $count + 1;
		}
	}
	echo "</tr></table>";
	}
	?>
	    <?php
	$data = $wpdb->get_results("select eemail_id,eemail_subject  from ".WP_eemail_TABLE." where 1=1 and eemail_status='YES' order by eemail_id desc");
	if ( !empty($data) ) 
	{
	foreach ( $data as $data )
	{
		if($data->eemail_subject <> "")
		{
			@$eemail_subject_drop_val = @$eemail_subject_drop_val . '<option value="'.$data->eemail_id.'">' . stripcslashes($data->eemail_subject) . '</option>';
		}
	}
	}
	?>
	<div id="wpbe_preview_message"></div>
	 <div>
	 	<a href="javascript:void(0);" class="button" id="wpbe_send_preview"><?php _e('Send', 'wp-better-emails'); ?></a><span id="wpbe_loading"></span>
	 	<img src="<?php echo admin_url('images/wpspin_light.gif'); ?>" id="wpbe_ajax_loading" style="visibility: hidden;" alt="Loading" />
	 	<br /><span class="description"><?php _e('You must save your template before sending an email preview.', 'wp-better-emails'); ?></span>
	 </div>
	  </form>
	 </div>
	<!-- test -->

</div>