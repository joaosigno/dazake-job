<?php 
function dk_blogger_render_tpl(){
	if(!empty($_POST['submit'])){
		//update display number
		if(!empty($_POST['dk_bloger_list_num'])){
			update_option( 'dk_bloger_list_num', $_POST['dk_bloger_list_num'] );
		}

		//update display order
		if(!empty($_POST['dk_bloger_list_order'])){
			update_option( 'dk_bloger_list_order', $_POST['dk_bloger_list_order'] );
		}
	}

	$dk_bloger_list_order = get_option('dk_bloger_list_order');
	$dk_bloger_list_num = get_option('dk_bloger_list_num');
?>
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>DK blogger list option setting</h2>
	<form action="" method = "POST">
	<table>
		<tr>
			<td>
				Blogger list num:
			</td>
			<td>
				<select name="dk_bloger_list_num" id="dk_bloger_list_num">
					<?php for($i = 1 ; $i < 10 ; $i++) :?>
						<option value="<?php echo $i ;?>" <?php if($dk_bloger_list_num == $i ) echo 'selected = true' ;?>>
							<?php echo $i ;?>
						</option>
					<?php endfor;?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				Blogger list order:
			</td>
			<td>
				<select name="dk_bloger_list_order" id="dk_bloger_list_order">
					<option value="random" <?php if($dk_bloger_list_order == 'random' ) echo 'selected = true' ;?> >Random</option>
					<option value="last" <?php if($dk_bloger_list_order == 'last' ) echo 'selected = true' ;?> >Last post blogger</option>
				</select>
			</td>
		</tr>
	</table>

	<p class="submit">
			<input type="submit" name = "submit"  value = "Save Changed">
	</p>
	</form>
<?php
}



function dk_blogger_list_setting_render_tpl(){
	//get users
	$wp_user_search = new WP_User_Query( array( 'role' => 'Contributor' ) );
	$subscriber = $wp_user_search->get_results();

?>
<div id="icon-options-general" class="icon32"><br></div>
<h2>DK blogger list  setting</h2>
	<table class = "wp-list-table widefat fixed users dk_user_table" >
		<thead id = "dk_user_tbody" style="background-color:#DFDFDF" height=60px >
			<tr>
				<td>Blogger Image:</td>
				<td>Blogger Name:</td>
				<td></td>
			</tr>	
		</thead>
		<?php foreach($subscriber as $key => $value) :?>
		<tr class= "dazake_blogger_list_table_tr">
			<?php 
				$userimage = get_user_option( 'dk_blogger_image', $value->ID);
			?>
			<td><img height=60 width=64 src="<?php echo $userimage ;?>" alt=""></td>
			<td ><?php echo $value->user_nicename;?></td>
			<td><a href="admin.php?page=dk_blogger_list_setting&edite=true&id=<?php echo $value->ID ;?>">edite</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
<?php	
}

function dk_blogger_list_setting_render_edite_tpl(){

	if(!empty($_POST['submit'])){
		if(!empty($_POST['dk_blogger_image'])){
			$result = update_user_option( $_GET['id'],'dk_blogger_image', $_POST['dk_blogger_image'] );
			print_r($result);
		}

	}

	if(!empty($_GET['id'])){
		$nickname = get_user_option( 'nickname', $_GET['id'] );
		$userimage = get_user_option( 'dk_blogger_image', $_GET['id'] );
	}
?>
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>Blogger Info edite</h2>
	<form action="admin.php?page=dk_blogger_list_setting&edite=true&id=<?php echo $_GET['id'] ;?>" method="POST">
		<table>
			<tr>
				<td>Name:</td>
				<td><?php echo $nickname ;?></td>
			</tr>
			<tr>
				<td>Image:</td>
				<td><input type="text" name = "dk_blogger_image" value = "<?php echo $userimage ;?>"></td>
			</tr>
			<tr>
				<td>Image:</td>
				<td><img src="<?php echo $userimage ;?>" alt=""></td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" name = "submit"  value = "Save Changed">
		</p>
	</form>
<?php
}

