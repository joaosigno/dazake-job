<?php 
	//init read status
	if(!empty($nr_statuses))
		unset($nr_statuses);
	$nr_statuses['unread'] = 'NEWLY ADDED';
	$nr_statuses['reading'] = 'READING NOW';
	$nr_statuses['rcd'] = 'STRONGLY RECOMMENDED';
        $nr_statuses['beachr'] = 'FAVOURITES FOR THE BEACH';
	$nr_statuses['rainyr'] = 'GREAT FOR RAINY DAYS';
	$nr_statuses['goodr'] = 'FAVOURITE FEEL-GOOD READS';
	$nr_statuses['comr'] = 'GREAT COMMUTE READS';
        $nr_statuses['pastr'] = 'MY PESONAL WISH LIST';
        $nr_statuses['nrecd'] = "BEST AVOIDED";
	
	global $userdata;
?>

<div id="dk-bookshelf" data-url="<?php echo plugins_url( '/functions/edit.php' , dirname(__FILE__) )?>">
	<div id="dk-navi">
		<a href="<?PHP echo DK_MANAGE_BOOK_URL ;?>">Manage books</a>
	</div>

	<?php foreach($nr_statuses as $key => $value) :?>
            <!-- stats loop -->
            <?php 
            	if ( !empty($_GET['dkq']) )
				$search = '&search=' . urlencode($_GET['dkq']);
			else
				$search = '';

			if ( empty($_GET['dkp']) )
				$page = 1;
			else
				$page = intval($_GET['dkp']);

			if ( empty($_GET['dko']) )
				$order = 'desc';
			else
				$order = urlencode($_GET['dko']);

			if ( empty($_GET['dks']) )
				$orderby = 'started';
			else
				$orderby = urlencode($_GET['dks']);

			// Filter by Author.
			if (empty($_GET['author']))
				$author = '';
			else
				$author = "&author=" . urlencode($_GET['author']);

			// Filter by Status.
			$_GET['status'] = $key; //set status
			if (empty($_GET['status']))
				$status = '';
			else
				$status = "&status=" . urlencode($_GET['status']);

			$offset = 0;
			$num = 50;
			$pageq = "&num=$num&offset=$offset";

			// Depends on multiuser mode.
			if ($options['multiuserMode']) {
				$reader = "&reader=".$userdata->ID;
			} else {
				$reader = "&reader=".$userdata->ID;//always multiuser mode
			}

			$books = dk_get_books("num=-1&status=all&orderby={$orderby}&order={$order}{$search}{$pageq}{$reader}{$author}{$status}");
				
            ?>
		<div class="dk-category" data-status="<?php echo $key?>">
			<h4 class="dk-title"><?php echo $value?><span class="dk-switch">▼</span></h4>
			<div class="dk-container-out <?php if($key != 'unread') echo 'dk-hide' ;?>">
				<div class="dk-container-in">
					<?php foreach ((array)$books as $book):?>
						<div class="dk-book" data-id="<?php echo $book->id;?>">
							<div class="dk_bookshelf_view">
								<?php
									echo '<a href="'.DK_MANAGE_BOOK_URL .'?ig=ig&dkaction=manage&amp;action=viewbook&amp;id=' . $book->id . '">' . __('View', NRTD) . '</a>';
								?>
							</div>
							<img src="<?php echo $book->image ;?>" alt="">
						</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	<?php endforeach;?>
	
</div>
