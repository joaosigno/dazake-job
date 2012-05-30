collection.php
<?php
	if(function_exists('wp_nav_menu')):
			wp_nav_menu(
					array(
					'menu' =>'Pro_nav',
					'container'=>'',
					'depth' => 2,
					'menu_id' => 'Pro_nav' )
			);
	else:
?>
<?php wp_list_pages('title_li=&depth=2'); ?>
<?php
	endif;
?>
