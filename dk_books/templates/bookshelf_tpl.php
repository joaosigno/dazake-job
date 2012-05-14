<?php 
	//init read status
	if(!empty($nr_statuses))
		unset($nr_statuses);
	$nr_statuses['unread'] = 'New Book';
	$nr_statuses['reading'] = 'Reading now';
	$nr_statuses['rcd'] = 'I recommend';
	$nr_statuses['nrecd'] = "I wouldn't recommend";
	$nr_statuses['beachr'] = 'My beach reads';
	$nr_statuses['rainyr'] = 'My rainy day reads';
	$nr_statuses['goodr'] = 'My feel-good reads';
	$nr_statuses['comr'] = 'My commute reads';
	$nr_statuses['pastr'] = 'Past reads';
?>

<div id="dk-bookshelf">
	<div id="dk-navi">
		<a href="">Manage Books</a>
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

			$offset = 1;
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
			<h4 class="dk-title"><?php echo $value?></h4>
			<div class="dk-container-out">
				<div class="dk-container-in">
					<?php foreach ((array)$books as $book):?>
						<div class="dk-book" data-id="<?php echo $book->id;?>">
							<img src="<?php echo $book->image ;?>" alt="">
							<span class="dk-booktitle"><?php echo $book->title ;?></span>
						</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	<?php endforeach;?>
	
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo plugins_url( '/js/jquery-ui.js' , dirname(__FILE__) )?>"></script>
<script type="text/javascript" src="<?php echo plugins_url( '/js/main.js' , dirname(__FILE__) )?>"></script>
</body>
</html>