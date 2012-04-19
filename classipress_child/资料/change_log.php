<?php
### 1,classipress/includes/admin-options.php
//Add "Premium Packages" submenu for managing packages.
##add
#line 22
// add_submenu_page( basename(__FILE__), __('Dazake Packages','appthemes'), __('Dazake Packages','appthemes'), 'manage_options', 'dazake_packages', 'cp_ad_dazake_packs' );
add_submenu_page( basename(__FILE__), __('Premium Packages','appthemes'), __('Premium Packages','appthemes'), 'manage_options', 'premium_packages', 'cp_ad_premium_packs' );
//end edite by dazake 
##endadd

##add
#line 1174
		
// show the ad premium packages admin page
function cp_ad_premium_packs(){
	//update Categories
	if(isset($_POST['dazake_category_submit'])){
		if(isset($_POST['dazake_category_check'])){
			foreach($_POST['dazake_category_check'] as $value){
				$pricename = "dazake_category{$value}_price";
				$pricefeaturename = "dazake_category{$value}_price_feature";
				$pinumname = "dazake_category{$value}_pic_num";
				
				if(isset($_POST[$pricename ]))
					update_option( $pricename, $_POST[$pricename ] );
					
				if(isset($_POST[$pinumname]))
					update_option( $pinumname, $_POST[$pinumname] ) ;
								
				if(isset($_POST[$pricefeaturename]))
					update_option( $pricefeaturename, $_POST[$pricefeaturename] ) ;
			}
			
		}	
		
		//update free pic nums
		if(isset($_POST['dazakefreepicnum']))
			update_option( 'dazakefreepicnum', $_POST['dazakefreepicnum'] ) ;
				
		//update feature pic nums
		if(isset($_POST['dazakefeaturepicnum']))
			update_option( 'dazakefeaturepicnum', $_POST['dazakefeaturepicnum'] ) ;
			
		//update feature time
		if(isset($_POST['dazakefeaturetime']))
			update_option( 'dazakefeaturetime', $_POST['dazakefeaturetime'] ) ;
			
		//update premium time
		if(isset($_POST['dazakepremiumtime']))
			update_option( 'dazakepremiumtime', $_POST['dazakepremiumtime'] ) ;
			
		//update free time 
		if(isset($_POST['dazakefreetime']))
			update_option( 'dazakefreetime', $_POST['dazakefreetime'] ) ;
			
	}
	
	$categories = get_categories( array('hide_empty' => 0,
                                       'taxonomy' 	 => APP_TAX_CAT) );
?>
<div class="wrap">
    <div class="icon32" id="icon-themes"><br/></div>
        <h2><?php _e('Ad Premium Packs','appthemes') ?>&nbsp;</h2>
        <?php cp_admin_info_box(); ?>
		<form method = "POST">
		<p class = "submit">
		<input class = "btn button-primary" type = "submit" name = "dazake_category_submit" value = "<?php _e('Save changes','appthemes') ?>" >
		</p>
		
		
		<table>
		<tr>
			<td><span class = "dazakespan">Ad Listing Period Of Feature:</span></td>
			<td><input type = "text" class = "dazaketext" name = "dazakefeaturetime" value = "<?php echo get_option('dazakefeaturetime')?>"></td>
		</tr>
		<tr>
			<td><span class = "dazakespan">Ad Listing Period Of Premium:</span></td>
			<td><input type = "text" class = "dazaketext" name = "dazakepremiumtime" value = "<?php echo get_option('dazakepremiumtime')?>"></td>
		</tr>
		<tr>
			<td><span class = "dazakespan">Ad Listing Period Of Free:</span></td>
			<td><input type = "text" class = "dazaketext" name = "dazakefreetime" value = "<?php echo get_option('dazakefreetime')?>"></td>
		</tr>
		
		
		<tr>
			<td><span class = "dazakespan">Pic Num Of Free</span></td>
			<td><select name="dazakefreepicnum" class="dazakeselect">  
				<?php 
					for ($i=1; $i <9 ; $i++) { 
						if($i == get_option('dazakefreepicnum'))
							echo '<option value="'.$i.'" selected= "true">'.$i.'</option> ';
						else
							echo '<option value="'.$i.' ">'.$i.'</option> ';
					}
				?>
				
			</select></td>
		</tr>
		<tr>
			<td><span class = "dazakespan">Pic Num Of Feature</span></td>
		<td><select name="dazakefeaturepicnum" class="dazakeselect">  
				<?php 
					for ($i=1; $i <9 ; $i++) { 
						if($i == get_option('dazakefeaturepicnum'))
							echo '<option value="'.$i.'" selected= "true">'.$i.'</option> ';
						else
							echo '<option value="'.$i.' ">'.$i.'</option> ';
					}
				?>		
		</select></td>
		</tr>
		
		</table>
		
		<table id="tblspacer" class="widefat fixed">
            <thead>
            <tr>
                <th scope="col" style="width:35px;">&nbsp;</th>
                <th scope="col"><?php _e('Categories Name','appthemes') ?></th>
                <th scope="col"><?php _e('Price Per Categories','appthemes') ?></th>
                <th scope="col"><?php _e('Feature Price Per Categories','appthemes') ?></th>
                <th scope="col"><?php _e('Pic Num Of The Categories','appthemes') ?></th>
                <th scope="col"><?php _e('Update Check','appthemes') ?></th>
            </tr>
        </thead>
		<tbody id="list">
		
<?php
	$add = 1;
	foreach($categories as $key => $value){
	$catid = $value->cat_ID;
	$pricename = "dazake_category{$catid}_price";
	$pricefeaturename = "dazake_category{$catid}_price_feature";
	$pinumname = "dazake_category{$catid}_pic_num";
?>
	<tr class="<?php echo $value->category_nicename ?>">
        <td style="padding-left:10px;"><?php echo $add++; ?>.</td>
        <td><?php echo $value->cat_name ?></td>
        <td><input type = "text" name = "<?php echo $pricename ?>" value = "<?php echo get_option($pricename);?>" ><span><?php echo get_option('cp_curr_pay_type')?></span></td>
        <td><input type = "text" name = "<?php echo $pricefeaturename ?>" value = "<?php echo get_option($pricefeaturename);?>" ><span><?php echo get_option('cp_curr_pay_type')?></span></td>
        <td>
			<select name="<?php echo $pinumname ?>" class="dazakeselect">  
				<?php 
					for ($i=1; $i <9 ; $i++) { 
						if($i == get_option($pinumname))
							echo '<option value="'.$i.'" selected= "true">'.$i.'</option> ';
						else
							echo '<option value="'.$i.' ">'.$i.'</option> ';
					}
				?>
				
			</select>  
		</td>
        <td><input type="checkbox" class = "dazakecheck" name="dazake_category_check[]" value = "<?php echo $value->cat_ID ?>"></td>
    </tr>
<?php
}//end foreach
?>
	</tbody>
	</table>
	</form>
<?php
}//end premium packages function

##end add
### end1,classipress/includes/admin-options.php

###2，classipress/includes/admin-post-types.php
//Add premium checkbox to quick edit and editing mode.

##replace
#line 287
//origin:
<span id="sticky"><input id="sticky" name="sticky" type="checkbox" value="sticky" <?php checked(is_sticky($post->ID)); ?> tabindex="4" /> <label for="sticky" class="selectit"><?php _e('Featured Ad (sticky)', 'appthemes') ?></label><br /></span>
//end origin:
//replace with:
<span id="sticky" class = "dazakefeature"><input id="sticky" name="sticky" type="checkbox" value="sticky" <?php checked(is_sticky($post->ID)); ?> tabindex="4" /> <label for="sticky" class="selectit"><?php _e('Featured Ad (sticky)', 'appthemes') ?></label><br /></span>
//end replace with
#end line 287

#add
#line 289

	<div class="misc-pub-section misc-pub-section-last post-type-switcher">
		<span id="premium" class = "dazakepremium"><input id="premium" name="premium" type="checkbox" value="premium" 
		<?php 
			$arr_premium = get_option('dazake_premium_posts');
			if(!is_array($arr_premium))
				$arr_premium = array();
			checked(in_array($post->ID,$arr_premium)); 
		?> tabindex="4" /> <label for="premium" class="selectit"><?php _e('Premium Ad (premium)', 'appthemes') ?></label><br /></span>
	</div>
#end line 289

##add
#line 319
<fieldset class="inline-edit-col-right dazakeapt310">
		<div class="inline-edit-col">
			<label class="alignleft">
				<input type="checkbox" name="premium" value="premium"  
				<?php 
					$arr_premium = get_option('dazake_premium_posts');
					if(!is_array($arr_premium))
						$arr_premium = array();
					checked(in_array($post->ID,$arr_premium)); 
				?>/>
				<span class="checkbox-title"><?php _e('Premium Ad (premium)', 'appthemes'); ?></span>
			</label>
		</div>	
	</fieldset>
#end line 319

##add 
#line 356

		(function($){
			$(function(){
				$.get("post.php", { test:'bryanttest'} );
			});
		})(jQuery);
#end line 356

##add
#line 377
//dazakejs
		function quickEditBook() {
    var $ = jQuery;
    var _edit = inlineEditPost.edit;
    inlineEditPost.edit = function(id) {
        var args = [].slice.call(arguments);
        _edit.apply(this, args);

        if (typeof(id) == 'object') {
            id = this.getId(id);
        }
        if (this.type == 'post') {
            var
            // editRow is the quick-edit row, containing the inputs that need to be updated
            editRow = $('#edit-' + id),
            // postRow is the row shown when a book isn't being edited, which also holds the existing values.
            postRow = $('#post-'+id),

            // get the existing values
            // the class ".column-book_author" is set in display_custom_quickedit_book
            inprint = $('.dazake_premium_check', postRow).val();
			if(inprint === "true"){
				$(':input[name="premium"]', editRow).attr('checked', "checked");
			}
            
        }
    };
}
// Another way of ensuring inlineEditPost.edit isn't patched until it's defined
/*
if (inlineEditPost) {
    quickEditBook();
} else {
*/
    jQuery(quickEditBook);
/* } */
		//end dazake edite js
#end line 377

##add 
#line 512

//edite by dazake 


// hack until WP supports custom post type sticky feature
function cp_premium_option() {
	
	//if post is a custom post type and only during the first execution of the action quick_edit_custom_box
	if ($post->post_type == APP_POST_TYPE && did_action('quick_edit_custom_box') === 1): ?>
	<fieldset class="inline-edit-col-right dazakeapt">
		<div class="inline-edit-col">
			<label class="alignleft">
				<input type="checkbox" name="premium" value="premium"  />
				<span class="checkbox-title"><?php _e('Premium Ad (premium)', 'appthemes'); ?></span>
			</label>
		</div>	
	</fieldset>
	
<?php
	endif;
}
//add the sticky option to the quick edit area
add_action('quick_edit_custom_box', 'cp_premium_option');

add_action( 'save_post', 'save_premium_meta' );

function save_premium_meta( $post_id ) {
    /* in production code, $slug should be set only once in the plugin,
       preferably as a class property, rather than in each function that needs it.
     */

    //dazake  save  premium ads
    if ( isset( $_REQUEST['premium'] ) ) {
        if($_REQUEST['premium'] == 'premium'){
			$arr_premium = get_option('dazake_premium_posts');
			if(!is_array($arr_premium))
				$arr_premium = array();
			if(in_array($post_id, $arr_premium))
				return true;
			else{
				$arr_premium[] = $post_id;
				update_option('dazake_premium_posts', $arr_premium);
			}
		}else{
			$arr_premium = get_option('dazake_premium_posts');
			if(!is_array($arr_premium))
				$arr_premium = array();
			if(in_array($post_id, $arr_premium)){
				foreach($arr_premium as $key=>$value){
					if($value == $post_id)
						unset($arr_premium[$key]);
				}
				update_option('dazake_premium_posts', $arr_premium);
			}else{
				return true;
			}
		}	
    }else{
		$arr_premium = get_option('dazake_premium_posts');
		if(!is_array($arr_premium))
			$arr_premium = array();
		if(in_array($post_id, $arr_premium)){
			foreach($arr_premium as $key=>$value){
				if($value == $post_id)
					unset($arr_premium[$key]);
			}
		update_option('dazake_premium_posts', $arr_premium);
		}else{
			return true;
		}	
	}
}


/* example of how an existing value can be stored in the table */
add_action( 'manage_posts_custom_column' , 'custom_book_column', 10, 2 );
function custom_book_column( $column, $post_id ) {

	switch ( $column ) {
      case 'cp_price':
		$arr_premium = get_option('dazake_premium_posts');
		if(!is_array($arr_premium))
			$arr_premium = array();
        if ( in_array($post_id,$arr_premium)) {
            $checked = 'true';
        } else {
            $checked = 'false';
        }
        echo '<input  style = "display:none" type= "text" class = "dazake_premium_check" value = "'.$checked.'" />';
		break;
		
	 case 'ad_cat':
	    $arr_premium = get_option('dazake_premium_posts');
		if(is_array($arr_premium)){
			if ( in_array($post_id,$arr_premium)) {
				echo '</br><div style = " font-weight:bold" class = "dazake_premium_display post-state" >Ppremium</div>';
			} else {
				return ;
			}
		}else{
			return false;
		}
		break;  
    }
}
//end edite by dazake
#end line 512

###3，classipress/includes/forms/step1.php
##replace
#line 98:
//origin:
	 <?php } else {
//replace with :
	 <?php } elseif(!isset($_POST['stepadd'])) {
#end line 98

##add
#line 103
<ul class = "dazakeul">
						<li class="withborder">
							<div class="labelwrapper">
							<label><?php _e('Featured Listing','appthemes'); ?> <?php echo cp_pos_price(cp_ad_dazake_feature_listing_free($_POST['cat'])); ?></label>
							</div>
							<div class="clr"></div>
								<input type="radio" name="dazakepacks" value="featured" >
								<?php _e('Your listing will appear in the featured slider section at the top of the front page.','appthemes'); ?>
							<div class="clr"></div>
						</li>
						
						<li class="withborder">
							<div class="labelwrapper">
							<label><?php _e('Premium Listing','appthemes'); ?> <?php cp_pos_price(cp_ad_dazake_premium_listing_free($_POST['cat'])); ?></label>
							</div>
							<div class="clr"></div>
								<input type="radio" name="dazakepacks" value="premium" >
								<?php 
									_e("Your will allow to upload ",'appthemes');
									echo get_option("dazake_category{$_POST['cat']}_pic_num");
									_e(" images ",'appthemes'); 
								
								?>
							<div class="clr"></div>
						</li>
						

						<li class="withborder">
							<div class="labelwrapper">
							<label><?php _e('Free Listing','appthemes'); ?> </label>
							</div>
							<div class="clr"></div>
								<input type="radio" name="dazakepacks" value="free" >
								<?php 
									_e('Your listing will only upload  ','appthemes'); 
									echo get_option('dazakefreepicnum');;
									_e(' images ','appthemes'); 
								?>
							<div class="clr"></div>
						</li>
						
					</ul>
                    <p class = "btn1" ><input class = "btn_orange" type="submit" name="stepadd" value = "<?php _e('Continue &rsaquo;&rsaquo;','appthemes'); ?>"></p>
                    <input type="hidden" id="cat" name="cat" value="<?php echo $_POST['cat']; ?>" />
                    <input type="hidden" id="catname" name="catname" value="<?php echo $_POST['catname']; ?>" />
                    <input type="hidden" id="fid" name="fid" value="<?php if(isset($_POST['fid'])) echo $_POST['fid']; ?>" />
                    <input type="hidden" id="oid" name="oid" value="<?php echo $order_id; ?>" />
                </form>
            <?php } ?>



<!-- edite by dazake add one step before input files -->
            <?php
                if ( isset($_POST['cat'] ) && ($_POST['cat'] != '-1') && isset($_POST['stepadd']) ) {

                // show the form based on the category selected
                // get the cat nice name and put it into a variable
                $adCategory = get_term_by( 'id',$_POST['cat'], APP_TAX_CAT );
                $_POST['catname'] = $adCategory->name;
            ?>
                 <form name="mainform" id="mainform" class="form_step" action="" method="post" enctype="multipart/form-data">
				 #endline 103
				 
				 ##add
				 #line 181
				 <input type="hidden" id="dazakepacks" name="dazakepacks" value="<?php echo $_POST['dazakepacks']; ?>" />
				 #end line 181
				 
##add
#line 188
 <?php
                }
            ?>
#end line 188


###classipress/includes/forms/step2.php
##replace:
#line 63
//origin:
	if ( isset($_POST['featured_ad']) ) {
        $postvals['featured_ad'] = $_POST['featured_ad'];
        // get the featured ad price into the array
        $postvals['cp_sys_feat_price'] = get_option('cp_sys_feat_price');
    }
//replace with :
 if(isset($_POST['dazakepacks']) && ($_POST['dazakepacks'] == 'featured') ) {
        $postvals['featured_ad'] = True;
        // get the featured ad price into the array
        $postvals['cp_sys_feat_price'] = cp_ad_dazake_feature_listing_free($_POST['cat']);
    }
#end line 63

##add
#line 68
// see if the dazake premium ad has been checked
    if (isset($_POST['dazakepacks']) && ($_POST['dazakepacks'] == 'premium' )) {
        $postvals['premium_ad'] = $_POST['dazakepacks'];
        $postvals['cp_sys_premium_price'] = cp_ad_dazake_premium_listing_free($_POST['cat']);
    }
#end line 68

##replace
#line 106
//origin:
	else $postvals['cp_sys_total_ad_cost'] = cp_calc_ad_cost($_POST['cat'], $adpackid, 0, $_POST['cp_price'], $coupon);
//replace with:
	elseif(isset($postvals['cp_sys_premium_price'])) 
		$postvals['cp_sys_total_ad_cost'] = cp_calc_ad_cost($_POST['cat'], $adpackid, $postvals['cp_sys_premium_price'], $_POST['cp_price'], $coupon);
	else
		$postvals['cp_sys_total_ad_cost'] = cp_calc_ad_cost($_POST['cat'], $adpackid, 0, $_POST['cp_price'], $coupon);
	
#end line 106


###classipress/includes/forms/step3.php
##add 
#line 48
//record the premium post id .
		if (isset($_POST['dazakepacks']) && ($_POST['dazakepacks'] == 'premium' )) {
			$dazake_premium_posts = array();
			$dazake_premium_posts = get_option('dazake_premium_posts');
			$dazake_premium_posts[] = $post_id;
			update_option('dazake_premium_posts',$dazake_premium_posts );
		}
		
#end line 48


###classipress/includes/forms/stepfunction.php
##add
#line 199
function cp_dazake_image_details($catid){
	global $wpdb;
	if(isset($catid))
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "cp_ad_dazake_packs WHERE categories = $catid ORDER BY id desc" ) );
	if($results)
		return $results;
}
#end line 199

##add
#line 209
global $wpdb;
	$imgnum = 1;
	
	if(isset($_POST['dazakepacks']) && isset($_POST['cat'])){
		if($_POST['dazakepacks'] == 'free')
			$imgnum = get_option('dazakefreepicnum');
		elseif($_POST['dazakepacks'] == 'featured')
			$imgnum = get_option('dazakefeaturepicnum');
		elseif($_POST['dazakepacks'] == 'premium'){
			$catid = $_POST['cat'];
			$results = get_option("dazake_category{$catid}_pic_num");
			if($results)
				$imgnum = $results;
		}	
	}
	
	
    for ( $i=0; $i < $imgnum; $i++ ) {
#end line 209

##add
#line 258
<!-- dazake donot show 
#end line 258

##add
#line 268
		-->
#end line 268

##replace
#line 503
//origin:
	 <?php if(isset($_POST['featured_ad'])) : ?>
//replace with:
	<?php if(isset($_POST['dazakepacks']) && ($_POST['dazakepacks'] == 'featured') ) : ?>
#end line 503


##add
#line 513
<!-- dazake premium -->
	<?php if(isset($_POST['dazakepacks']) && ($_POST['dazakepacks'] == 'premium') ) : ?>
        <li>
        	<div class="labelwrapper">
	            <label><?php _e('Premium Listing Fee','appthemes');?>:</label>
            </div>
            <div id="review"><?php echo cp_pos_price(number_format($postvals['cp_sys_premium_price'], 2)); ?></div>
            <div class="clr"></div>
        </li>
    <?php endif; ?>
#end line 513

##add 
#line 607

//dazake premium listing free
function cp_ad_dazake_premium_listing_free($catid){
	global $wpdb;
	if(get_option('cp_charge_ads') == 'yes') {
		// make sure we have something if ad_pack_id is empty so no db error
        if(empty($catid))
            $catid = 1;
		
		// go get all the active ad packs and create a drop-down of options

        $results = get_option("dazake_category{$_POST['cat']}_price");
		
		// now return the price and put the duration variable into an array
        if(!empty($results)) {
            return $results;
        } else {
            return '0.00';
        }
	}
}

//dazake feature listing free
function cp_ad_dazake_feature_listing_free($catid){
	global $wpdb;
		// make sure we have something if ad_pack_id is empty so no db error
        if(empty($catid))
            $catid = 1;
		
		// go get all the active ad packs and create a drop-down of options

        $results = get_option("dazake_category{$_POST['cat']}_price_feature");
		
		// now return the price and put the duration variable into an array
        if(!empty($results)) {
            return $results;
        // $postvals['pack_duration'] = $results->pack_duration;
        } else {
            return '0.00';
        }
	
}
#end line 607

##add
#line 873
//dazake set duration time 
		if(isset($_POST['dazakepacks'])){
			if($_POST['dazakepacks'] == 'free')
				$ad_length = get_option('dazakefreetime');
			elseif($_POST['dazakepacks'] == 'featured')
				$ad_length = get_option('dazakefeaturetime');
			elseif($_POST['dazakepacks'] == 'premium'){
				$ad_length = get_option('dazakepremiumtime');
			}   
		}
	}
#line 873

###4， classipress_child/loop-adlisting.php
##replace
#line 15
//origin:
	<div class="pack"><a href="javascript: void(0);" id="mode"<?php if ($_COOKIE['mode'] == 'grid') echo ' class="flip"'; ?>></a></div>
//replace with :
	<div class="pack"></div>

##replace
#line 17
//origin:
<div id="loop" class="<?php if ($_COOKIE['mode'] == 'grid') echo 'grid'; else echo 'list'; ?> clear">
//replace with:
<div id="loop" class="flip clear">
#end line 17

##add
#line 29
<?php
				$display = '<div class="post-block-out">';
				global $displaytype ;
				if(isset($displaytype)){
					switch ($displaytype) {
						case 'feature':
							if(is_sticky($post_ID) == true)
								$display = '<div class="post-block-out">';
							else
								$display = '<div class="hide">';
						break;
						case 'premium':
							if((!is_sticky($post_ID) == true ) && dazake_is_premiun($post->ID))
								$display = '<div class="post-block-out">';
							else
								$display = '<div class="hide">';
						break;
						case 'free':
							if(dazake_is_free($post->ID))
								$display = '<div class="post-block-out">';
							else
								$display = '<div class="hide">';
						break;
						case 'all':
							$display = '<div class="post-block-out">';
						break;
		
						default:
							$display = '<div class="hide">';
						break;
					}
				}
				echo $display;
			
			?>
#end line 29

##replace
#line  70
#oring:
 <div class="post-block-out">

	            <div class="<?php if(is_sticky($post_ID) == true) echo 'post-block-featured'; else echo 'post-block'; ?>">
#replace with:
<div class="<?php if( is_sticky($post_ID) == true) echo 'post-block-featured'; elseif(dazake_is_premiun($post->ID)) echo 'post-block-premium';else echo 'post-block-free';?>">

##replace
#line 75
//origin:
	<?php if ($_COOKIE['mode'] == 'grid'){?> 
//replace with:
		 <?php 
									
					if ($_COOKIE['mode'] == 'changegrid')
					{
					
					// echo $_COOKIE['mode'];

	
					 ?> 
#end line 75

##replace 
#126
//oring:
  <?php } else { ?>



  <?php if ( get_option('cp_ad_images') == 'yes' ) cp_ad_loop_thumbnail(); ?>
                
//replace with:
<?php } else {
  
  					// echo $_COOKIE['mode'];
					
				
  
  ?>
  <?php 
	if ( get_option('cp_ad_images') == 'yes' ) {
		cp_ad_loop_thumbnail(); 
	}
  ?>
 
#end line 126

##replace 
#line 182
//origin :
 <?php appthemes_after_endwhile(); ?>
//replace with:
 <?php 
			//only display when the last loop
			global $displaytype ;
			if($displaytype == 'free' || $displaytype == 'all')
			appthemes_after_endwhile(); 
		?>
		
#end line 182

##replace 
#line 191
//oring:
<?php appthemes_loop_else(); ?>
//replace with:
 <?php 
			//only display when the last loop
			global $displaytype ;
			if($displaytype == 'free' || $displaytype == 'all')
				appthemes_loop_else(); 
		?>
		
#end line 191

###5，classipress_child/style.css
##add
#line 400

/*featured grid */
/*.grid .post-block-featured {border-radius: 10px;-ms-border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;-khtml-border-radius: 5px;padding: 3px;background-image: none;width:194px;background-color: transparent;background:#fff url(images/block_featuredbg.gif) repeat-x top;border:1px solid #fff;}
.grid .post-block-featured h3 {min-height: 34px;max-height: 34px;display: block;overflow: hidden;}
.grid .post-block-featured .post-right .price-wrap {float:right;margin-top:-95px;}
.grid .post-block-featured .post-right span.tag-head {background: url("images/price-tag-head-small.png") no-repeat scroll left top transparent;height:20px;margin:0;padding:0;width:26px;}
.grid .post-block-featured .post-right p.post-price {background-color:#ffff99; float:left; font:bold 13px Arial,Helvetica,sans-serif;padding:3px 6px 2px;text-shadow:0 1px 0 #FFFFFF;-khtml-border-radius: 0 4px 4px 0; -moz-border-radius: 0 4px 4px 0; -webkit-border-radius:0 4px 4px 0; border-radius:0 4px 4px 0;-moz-box-shadow: 1px 1px 5px #B7B7B7;-khtml-box-shadow: 1px 1px 5px #B7B7B7;-webkit-box-shadow: 1px 1px 5px #b7b7b7; box-shadow: 1px 1px 5px #B7B7B7;text-align: right;}
.grid .post-block-featured .post-left {float: left;}
.grid .post-block-featured .post-left a.preview img:hover {opacity:0.6;}
.grid .post-block-featured .post-block-featured .post-right {float:right;max-width:90px;min-width:90px;height:90px;}
.grid .post-block-featured .post-right-no-img {float:right;width:100%;}
.grid .post-block-featured .post-right {padding:8px 0 0 0;min-width:170px!important;float: left;}
.grid .post-block-featured .post-right.full {float: right;}
.grid .post-block-featured .post-right h3 {float:left; max-width:330px; margin:0; padding:0; font:bold 17px/1.0em Arial, Helvetica, sans-serif; color:#4f4f4f; text-decoration: none; text-shadow: 0 1px 0 #FFFFFF;}
.grid .post-block-featured .post-right-no-img h3 {float:left; max-width:430px; margin:0; padding:0; font:bold 17px/1.0em Arial, Helvetica, sans-serif; color:#4f4f4f; text-decoration: none; text-shadow: 0 1px 0 #FFFFFF;}
.grid .post-block-featured .post-right h3 a:hover, .grid .post-block-featured .post-right-no-img h3 a:hover {text-decoration: underline;}
.grid .post-block-featured .post-right p.post-meta, .grid .post-block-featured .post-right-no-img p.post-meta {color:#AFAFAF;font-size:11px;margin:0;padding:4px 0;text-shadow:0 1px 0 #FFFFFF;border-bottom:1px dotted #BDBDBD;}
.grid .post-block-featured .post-right span.owner, .grid .post-block-featured .post-right span.owner, .grid .post-block-featured .post-right-no-img span.owner {display: none;}
.grid .post-block-featured .post-right span.owner img.avatar, .grid .post-block-featured .post-right-no-img span.owner img.avatar, .grid .post-block-featured .post-right span.owner img.avatar {padding:0 7px 0 0;margin-bottom:-3px;}
.grid .post-block-featured .post-right p.post-desc, .grid .post-block-featured .post-right-no-img p.post-desc {margin:0; padding:6px 0;min-height:110px; text-transform:lowercase;}
.grid .post-block-featured .post-right p.adid, .grid .post-block-featured .post-right-no-img p.adid {clear:both; padding:0; float:right;font-size:11px;color:#AFAFAF;}
.grid .post-block-featured .post-right p.location, .grid .post-block-featured .post-right-no-img p.location {margin:0; padding:0;}
.grid .post-block-featured .post-right p.stats {clear: both;border-bottom: 1px solid #E2E2E2;border-top: 1px solid #E2E2E2;background: url(images/li_grayarrow.gif) no-repeat 1px 5px;padding-top: 0!;padding-bottom: 0!important;padding-left:12px;font-size:11px;color:#AFAFAF;float: left;width:170px;}
.post-block-featured .sticky-post-class {background-attachment: scroll;background-clip: border-box;background-color: transparent;background-origin: padding-box;background-position: 0 0;background-repeat: no-repeat;background-size: auto auto;display: block; height: 40px;position: absolute;width: 40px;z-index: 300;}
.grid .post-block-featured .post-right p.post-meta {color:#AFAFAF;font-size:11px;margin:0;padding:4px 0;text-shadow:0 1px 0 #FFFFFF;border-bottom:1px dotted #BDBDBD;border-top:1px dotted #BDBDBD;margin-top:8px;}
.grid .post-block-featured .post-right span.folder a {padding:0 0 0 22px;}
.grid .post-block-featured .post-right span.clock {font-size:11px;color:#AFAFAF;float: right;position: absolute;bottom: 225px;right: 5px;}
*/

#end line 400

##add
#line 443

/* dazake */

/* ad loop block free*/
.post-block-out { margin:0 0 8px 0; border:1px solid #bbb; -khtml-border-radius: 6px; -moz-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px; }

.post-block-free{ width:600px; background: url("images/block_topbg.gif") repeat-x scroll center top #FFFFFF; margin:0; padding:10px 13px 6px; border:1px solid #fff; -khtml-border-radius: 6px; -moz-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px;}


.post-left {float:left;padding-right:15px; padding-top:5px;}
.post-left a.preview img:hover {opacity:0.6;}
.post-block-free .post-right {float:right;max-width:490px;min-width:380px;}
.post-block-free .post-right-no-img {float:right;width:100%;}
.post-block-free .full {width:100%;}
.post-block-free .post-right h3 {float:left; max-width:290px; margin:0; padding:0; font:bold 14px/1.0em Arial, Helvetica, sans-serif; color:#4f4f4f; text-decoration: none; text-shadow: 0 1px 0 #FFFFFF;}
.post-block-free .post-right-no-img h3 {float:left; max-width:430px; margin:0; padding:0; font:bold 15px/1.0em Arial, Helvetica, sans-serif; color:#4f4f4f; text-decoration: none; text-shadow: 0 1px 0 #FFFFFF;}
.post-block-free .post-right h3 a, .post-block .post-right-no-img h3 a { text-decoration: none; }
.post-block-free .post-right h3 a:hover, .post-block .post-right-no-img h3 a:hover { text-decoration: underline; }
.post-block-free .post-right p.post-meta, .post-block .post-right-no-img p.post-meta {color:#AFAFAF;font-size:11px;margin:0;padding:4px 0;text-shadow:0 1px 0 #FFFFFF;border-bottom:1px dotted #BDBDBD;}
.post-block-free .post-right span.owner , .post-block .post-right-no-img span.owner {padding: 0 5px;}
.post-block-free .post-right span.owner img.avatar, .post-block .post-right-no-img span.owner img.avatar {padding:0 7px 0 0;margin-bottom:-3px;}
.post-block-free .post-right p.post-desc, .post-block .post-right-no-img p.post-desc { margin:0; padding:6px 0; text-transform:lowercase;}
.post-block-free .post-right p.stats, .post-block .post-right-no-img p.stats {clear:both; padding:0; float:right;font-size:11px;color:#AFAFAF;}
.post-block-free .post-right p.adid, .post-block .post-right-no-img p.adid {clear:both; padding:0; float:right;font-size:11px;color:#AFAFAF;}
.post-block-free .post-right p.location, .post-block .post-right-no-img p.location { margin:0; padding:0;}

.post-block-free .agregadosloop{
  display:none;
}

.post-block-free p.post-price {background-color:#ffff99; float:left; font:bold 14px Arial,Helvetica,sans-serif;margin:0;padding:3px 6px 2px;text-shadow:0 1px 0 #FFFFFF;-khtml-border-radius: 0 4px 4px 0; -moz-border-radius: 0 4px 4px 0; -webkit-border-radius: 0 4px 4px 0; border-radius: 0 4px 4px 0;-moz-box-shadow: 1px 1px 5px #B7B7B7;-khtml-box-shadow: 1px 1px 5px #B7B7B7;-webkit-box-shadow: 1px 1px 5px #b7b7b7; box-shadow: 1px 1px 5px #B7B7B7;}

.post-block-free .post-left img{
  width:80px;
  height:80px;
}

/* ad loop block premium */
.post-block-out { margin:0 0 8px 0; border:1px solid #bbb; -khtml-border-radius: 6px; -moz-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px; }

.post-block-premium { width:600px; background:url("images/block_premium.gif")repeat-x scroll center top white; margin:0; padding:13px; border:1px solid #fff; -khtml-border-radius: 6px; -moz-border-radius: 6px; -webkit-border-radius: 6px; border-radius: 6px;}/* agrandado */


.post-left {float:left;padding-right:15px; padding-top:5px;}
.post-left a.preview img:hover {opacity:0.6;}
.post-block-premium .post-right {float:right;max-width:460px;min-width:380px;}
.post-block-premium .post-right-no-img {float:right;width:100%;}
.post-block-premium .full {width:100%;}
.post-block-premium .post-right h3 {float:left; max-width:290px; margin:0; padding:0; font:bold 15px/1.0em Arial, Helvetica, sans-serif; color:#4f4f4f; text-decoration: none; text-shadow: 0 1px 0 #FFFFFF;}
.post-block-premium .post-right-no-img h3 {float:left; max-width:430px; margin:0; padding:0; font:bold 15px/1.0em Arial, Helvetica, sans-serif; color:#4f4f4f; text-decoration: none; text-shadow: 0 1px 0 #FFFFFF;}
.post-block-premium .post-right h3 a, .post-block .post-right-no-img h3 a { text-decoration: none; }
.post-block-premium .post-right h3 a:hover, .post-block .post-right-no-img h3 a:hover { text-decoration: underline; }
.post-block-premium .post-right p.post-meta, .post-block .post-right-no-img p.post-meta {color:#AFAFAF;font-size:11px;margin:0;padding:4px 0;text-shadow:0 1px 0 #FFFFFF;border-bottom:1px dotted #BDBDBD;}
.post-block-premium .post-right span.owner , .post-block .post-right-no-img span.owner {padding: 0 5px;}
.post-block-premium .post-right span.owner img.avatar, .post-block .post-right-no-img span.owner img.avatar {padding:0 7px 0 0;margin-bottom:-3px;}
.post-block-premium .post-right p.post-desc, .post-block .post-right-no-img p.post-desc { margin:0; padding:6px 0; text-transform:lowercase;}
.post-block-premium .post-right p.stats, .post-block .post-right-no-img p.stats {clear:both; padding:0; float:right;font-size:11px;color:#AFAFAF;}
.post-block-premium .post-right p.adid, .post-block .post-right-no-img p.adid {clear:both; padding:0; float:right;font-size:11px;color:#AFAFAF;}
.post-block-premium .post-right p.location, .post-block .post-right-no-img p.location { margin:0; padding:0;}




/* dazake */
.pack{display:none;}

#end line 443

##and 
#line 509
.hide{display:none}
#end line 509

###6， add classipress_child/taxonomy-ad_cat.php
		
###7， classipress_child/functions.php
#   for extra wordpress functions

##add
#line 28

function dazake_is_premiun($postid) {
	$arr_premium = get_option('dazake_premium_posts');
	if(is_array($arr_premium)){
		if(in_array($postid,$arr_premium))
			return true;
		else 
			return false;
	}else{
		return false;
	}
}

function dazake_is_free($postid) {
	$arr_premium = get_option('dazake_premium_posts');
	$arr_sticky = get_option('sticky_posts');

	if(!is_array($arr_premium))
		$arr_premium = array();
	if(!is_array($arr_sticky))
		$arr_sticky = array();
		
	if(in_array($postid,$arr_premium))
		return false;
	elseif(in_array($postid,$arr_sticky))
		return false;
	else
		return true;

}

#end line 28

###9， classipress_child/search.php
##   for customed searching orders

##replace
#line 40
//origin:
</div><!-- /shadowblock -->

				</div><!-- /shadowblock_out -->


                <?php get_template_part( 'loop', 'ad_listing' ); ?>
//replace with:
<?php 
						 if(function_exists('twg_tfsp_sort')) 
							twg_tfsp_sort();
						
				?>
						</div><!-- /shadowblock -->
						</div><!-- /shadowblock_out -->
						
				<?php
					if(isset($_POST['sort_order'])){
						$displaytype = 'all';
						get_template_part( 'loop', 'ad_listing' ); 
					}else{
						$displaytype = 'feature';
						get_template_part( 'loop', 'ad_listing' ); 

						global $displaytype ;
						$displaytype = 'premium';
						get_template_part( 'loop', 'ad_listing' ); 

						$displaytype = 'free';
						get_template_part( 'loop', 'ad_listing' ); 
					}
				?>
				
#end line 40

###10, classipress_child/images
##add
block_premium.gif








