<?php
/**
 * The admin interface for managing and editing books.
 * @package dk_book
 */

/**
 * Creates the manage admin page, and deals with the creation and editing of reviews.
 */
function dk_book_manage()
{
    global $wpdb, $nr_statuses, $nr_post_options, $userdata;

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

    get_currentuserinfo();

    $_POST = stripslashes_deep($_POST);

    $options = get_option(NOW_READING_OPTIONS);

    if (!$nr_url)
	{
        $nr_url = new nr_url();
        $nr_url->load_scheme($options['menuLayout']);

         $nr_url->urls['add'] = get_page_link(intval($_GET['page_id'])) . '?ig=ig&dkaction=add' ;
        $nr_url->urls['manage'] = get_page_link(intval($_GET['page_id'])) . '?ig=ig' ;

        $nr_url->multiple['add'] = get_page_link(intval($_GET['page_id'])) . '?ig=ig&dkaction=add' ;
        $nr_url->multiple['manage'] = get_page_link(intval($_GET['page_id'])) . '?ig=ig';
        $nr_url->single['add'] = get_page_link(intval($_GET['page_id'])) . '?ig=ig&dkaction=add' ;
        $nr_url->single['manage'] = get_page_link(intval($_GET['page_id'])) ;
    }

    if (!empty($_GET['updated']))
	{
        $updated = intval($_GET['updated']);

        if ( $updated == 1 )
            $updated .= ' book';
        else
            $updated .= ' books';

        echo '
		<div id="message" class="updated fade">
			<p><strong>' . $updated . ' updated.</strong></p>
		</div>
		';
    }

    if (!empty($_GET['deleted']))
	{
        $deleted = intval($_GET['deleted']);

        if ($deleted == 1)
            $deleted .= ' book';
        else
            $deleted .= ' books';

        echo '
		<div id="message" class="updated fade">
			<p><strong>' . $deleted . ' deleted.</strong></p>
		</div>
		';
    }

    $action = $_GET['action'];
    nr_reset_vars(array('action'));

	$options = get_option(NOW_READING_OPTIONS);
	$dateTimeFormat = 'Y-m-d H:i:s';
	if ($options['ignoreTime'])
	{
		$dateTimeFormat = 'Y-m-d';
	}

    switch ($action)
	{
	//view book
	case 'viewbook':
		include_once(dirname(dirname(__FILE__)) . '/templates/single_tpl.php');
		break;
		
	// Edit Book.
        case 'editsingle':
        {
	$id = intval($_GET['id']);
            $existing = get_book($id);
            $meta = get_book_meta($existing->id);
            $tags = join(get_book_tags($existing->id), ',');

            echo '
			<div class="wrap">
				<h2>' . __("Edit Book", NRTD) . '</h2>
				<a href = "'.DK_BOOKSHELF_URL.'" >' . __('My bookshelf', NRTD) . ' &raquo;</a>
				<a href = "'.get_page_link(intval($_GET['page_id']))  .'" >' . __("Manage books", NRTD) . ' &raquo;</a>

				<form method="post" action="' . get_option('siteurl') . '/wp-content/plugins/dk_books/functions/edit.php">
			';

            if ( function_exists('wp_nonce_field') )
                wp_nonce_field('now-reading-edit');
            if ( function_exists('wp_referer_field') )
                wp_referer_field();

            echo '
				<div class="book-image">
<br>
					<img style="float:left; margin-right: 10px;" id="book-image-0" alt="Book Cover" src="' . $existing->image . '" />
				</div>

				<h3><cite>' . $existing->title . '</cite><br /> by ' . $existing->author . '</h3>

				<table class="form-table" cellspacing="2" cellpadding="5">

				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="count" value="1" />
				<input type="hidden" name="id[]" value="' . $existing->id . '" />

				<tbody>
				';

			// Title.
            echo '
				<tr class="form-field">
					<th valign="top" scope="row">
						<label for="title-0">' . __("Title", NRTD) . '</label>
					</th>
					<td>
						<input type="text" class="main" id="title-0" name="title[]" value="' . $existing->title . '" />
					</td>
				</tr>
				';

			// Author.
            echo '
				<tr class="form-field">
					<th valign="top" scope="row">
						<label for="author-0">' . __("Author", NRTD) . '</label>
					</th>
					<td>
						<input type="text" class="main" id="author-0" name="author[]" value="' . $existing->author . '" />
					</td>
				</tr>
				';

			// ASIN.
            echo '
				<tr class="form-field">
					<th valign="top" scope="row">
					<label for="asin-0">' . __("ASIN", NRTD) . '</label>
					</th>
					<td>
					<input type="text" class="main" id="asin-0" name="asin[]" value="' . $existing->asin . '" />
					</td>
				</tr>
				';

			// Status.
            echo '
				<tr class="form-field">
					<th valign="top" scope="row">
						<label for="status-0">' . __("Status", NRTD) . '</label>
					</th>
					<td>
						<select name="status[]" id="status-0">
							';

				foreach ( (array) $nr_statuses as $status => $name ) {
					$selected = '';
					if ( $existing->status == $status )
						$selected = ' selected="selected"';

					echo '
									<option value="' . $status . '"' . $selected . '>' . $name . '</option>
								';
				}

				echo '
						</select>
					</td>
				</tr>';

			// Visibility.
            echo '
				<tr class="form-field">
					<th valign="top" scope="row">
						<label for="visibility-0">' . __("Visibility", NRTD) . '</label>
					</th>
					<td>
						<select name="visibility[]" id="visibility-0">
							';

					if ($existing->visibility)
					{
						// Public.
						echo '
									<option value="0">Private</option>
									<option value="1" selected="selected">Public</option>
								';
					}
					else
					{
						// Private.
						echo '
									<option value="0" selected="selected">Private</option>
									<option value="1">Public</option>
								';
					}

				echo '
						</select>
					</td>
				</tr>';

			// Added Date.
			if (!$options['hideAddedDate'])
			{
				$added = ( nr_empty_date($existing->added) ) ? '' : date($dateTimeFormat, strtotime($existing->added));
				echo '
					<tr class="form-field">
						<th valign="top" scope="row">
							<label for="added[]">' . __("Added", NRTD) . '</label>
						</th>
						<td>
							<input type="text" id="added-0" name="added[]" value="' . htmlentities($added, ENT_QUOTES, "UTF-8") . '" />
						</td>
					</tr>
					';
			}

			// Started Reading Date.
			$started = ( nr_empty_date($existing->started) ) ? '' : date($dateTimeFormat, strtotime($existing->started));

			// Finished Reading Date.
			$finished = ( nr_empty_date($existing->finished) ) ? '' : date($dateTimeFormat, strtotime($existing->finished));
     

			// Image URL.
            echo '
				
<tr class="form-field">

					<th valign="top" >
						<label for="image-0">' . __("Image", NRTD) . '</label>
					</th>
<br><br><br>
					<td>
						<input type="text" class="main" id="image-0" name="image[]" value="' . htmlentities($existing->image) . '" />
					</td>
				</tr>

				';
			// Rating.
            echo '
				<tr class="form-field">
					<th valign="top" scope="row">
						<label for="rating[]"><label for="rating">' . __("Rating", NRTD) . '</label></label>
					</th>
					<td>
						<select name="rating[]" id="rating-' . $i . '" style="width:100px;">
							<option value="unrated">&nbsp;</option>
							';
            for ($i = 10; $i >=1; $i--) {
                $selected = ($i == $existing->rating) ? ' selected="selected"' : '';
                echo "
										<option value='$i'$selected>$i</option>";
            }
            echo '
						</select>
					</td>
				</tr>
				';

			// Review.
            echo '
				<tr class="form-field">
					<th valign="top" scope="row">
						<label for="review-0">' . __("Review", NRTD) . '</label>
					</th>
					<td>
						<textarea name="review[]" id="review-' . $i . '" cols="50" rows="10" style="width:97%;height:200px;">' . htmlentities($existing->review, ENT_QUOTES, "UTF-8") . '</textarea>
						<small>
								<a accesskey="i" href="#" onclick="reviewBigger(\'' . $i . '\'); return false;">' . __("Increase size", NRTD) . ' (Alt + I)</a>
								&middot;
								<a accesskey="d" href="#" onclick="reviewSmaller(\'' . $i . '\'); return false;">' . __("Decrease size", NRTD) . ' (Alt + D)</a>
							</small>
					</td>
				</tr>

				</tbody>
				</table>

				<p class="submit">
					<input class="eMember_button" type="submit" value="' . __("Submit", NRTD) . '" />
				</p>

				</form>

			</div>


			';
		}
		break;

		// Book Manager.
		default:
		{
			//depends on multiusermode (B. Spyckerelle)
			if ($options['multiuserMode']) {
				$count = total_books(0, 0, $userdata->ID); //counting only current users books
			} else {
				$count = total_books(0, 0, $userdata->ID); //counting all books
			}


			if ( $count ) {
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
				if (empty($_GET['status']))
					$status = '';
				else
					$status = "&status=" . urlencode($_GET['status']);

				$perpage = $options['booksPerPage'];
				$offset = ($page * $perpage) - $perpage;
				$num = $perpage;
				$pageq = "&num=$num&offset=$offset";

				// Depends on multiuser mode.
				if ($options['multiuserMode']) {
					$reader = "&reader=".$userdata->ID;
				} else {
					$reader = "&reader=".$userdata->ID;//always multiuser mode
				}

				$books = dk_get_books("num=-1&status=all&orderby={$orderby}&order={$order}{$search}{$pageq}{$reader}{$author}{$status}");
				$count = count($books);

				$numpages = ceil(total_books(0, 0, $userdata->ID) / $perpage);

				$pages = '<span class="displaying-num">' . __("Pages: ", NRTD) . '</span>';

				if ( $page > 1 ) {
					$previous = $page - 1;
					$pages .= " <a class='page-numbers prev' href='{$nr_url->urls['manage']}&dkp=$previous&dks=$orderby&dko=$order'>&laquo;</a>";
				}

				for ( $i = 1; $i <= $numpages; $i++) {
					if ( $page == $i )
						$pages .= "<span class='page-numbers current'>$i</span>";
					else
						$pages .= " <a class='page-numbers' href='{$nr_url->urls['manage']}&dkp=$i&dks=$orderby&dko=$order'>$i</a>";
				}

				if ( $numpages > $page ) {
					$next = $page + 1;
					$pages .= " <a class='page-numbers next' href='{$nr_url->urls['manage']}&dkp=$next&dks=$orderby&dko=$order'>&raquo;</a>";
				}

				echo '
				<div class="wrap">
						<div id="dk-navi">
				';
				if (!empty($_GET['q']) || !empty($_GET['author']) || !empty($_GET['status']))
				{
					echo '
								<a href="' . $nr_url->urls['manage'] . '">' . __('Show all books', NRTD) . '</a>

					';
				}

				echo '
								<a href="'.DK_BOOKSHELF_URL.'">' . __('My bookshelf', NRTD) . '</a>
								<a href="' . get_page_link(intval($_GET['page_id']))  . '?ig=ig&dkaction=add">' . __('Add new book', NRTD) . '</a>
						</div>

						<div class="tablenav">
							<div class="tablenav-pages">
								' . $pages . '
							</div>
						</div>


					<br style="clear:both;" />

					<form method="post" action="' . get_option('siteurl') . '/wp-content/plugins/now-reading-redux/admin/edit.php">
				';

				if ( function_exists('wp_nonce_field') )
					wp_nonce_field('now-reading-edit');
				if ( function_exists('wp_referer_field') )
					wp_referer_field();

				echo '
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="count" value="' . $count . '" />
				';

				$i = 0;

				if ( $order == 'desc' )
					$new_order = 'asc';
				else
					$new_order = 'desc';

				$title_sort_link = "{$nr_url->urls['manage']}&p=$page&s=book&o=$new_order$author";
				$author_sort_link = "{$nr_url->urls['manage']}&p=$page&s=author&o=$new_order$author";
				$added_sort_link = "{$nr_url->urls['manage']}&p=$page&s=added&o=$new_order$author";
				$started_sort_link = "{$nr_url->urls['manage']}&p=$page&s=started&o=$new_order$author";
				$finished_sort_link = "{$nr_url->urls['manage']}&p=$page&s=finished&o=$new_order$author";
				$status_sort_link = "{$nr_url->urls['manage']}&p=$page&s=status&o=$new_order$author";

				echo '
					<table class="widefat post fixed" cellspacing="0">
						
						<tbody>
				';

				foreach ((array)$books as $book)
				{

					$meta = get_book_meta($book->id);
					$tags = join(get_book_tags($book->id), ',');

					$alt = ( $i % 2 == 0 ) ? ' alternate' : '';

					$delete = get_option('siteurl') . '/wp-content/plugins/dk_books/functions/edit.php?action=delete&id=' . $book->id;
					$delete = wp_nonce_url($delete, 'now-reading-delete-book_' .$book->id);


					echo '
						<tr class="manage-book' . $alt . '">

							<input type="hidden" name="id[]" value="' . $book->id . '" />
							<input type="hidden" name="title[]" value="' . $book->title . '" />
							<input type="hidden" name="author[]" value="' . $book->author . '" />

							<td>
								<img style="max-width:100px;" id="book-image-' . $i . '" class="small" alt="' . __('Book Cover', NRTD) . '" src="' . $book->image . '" />
							</td>

							<td class="post-title column-title">
								<strong>' . stripslashes($book->title) . '</strong>
								<div class="row-actions">
									<a href="' . get_page_link(intval($_GET['page_id'])) . '?ig=ig&dkaction=manage&amp;action=viewbook&amp;id=' . $book->id . '">' . __('View', NRTD) . '</a> |
									<a href="' . get_page_link(intval($_GET['page_id'])) . '?ig=ig&dkaction=manage&amp;action=editsingle&amp;id=' . $book->id . '">' . __('Edit', NRTD) . '</a> | <a href="' . $delete . '" onclick="return confirm(\'' . __("Are you sure you wish to delete this book permanently?", NRTD) . '\')">' . __("Delete", NRTD) . '</a>
								</div>
							</td>

							<td>' . $book->author . '
							</td>';

						

					echo '
						</tr>
					';

					$i++;

				}

				echo '
					</tbody>
					</table>

					</form>
				';

			} else {
				echo '
				<div class="wrap">
					<h2>' . __("Manage books", NRTD) . '</h2>
					<p>' . sprintf(__("No books to display. To add some books, head over <a href='%s'>here</a>.", NRTD), $nr_url->urls['add']) . '</p>
				</div>
				';
			}

			echo '
			</div>
			';
		}
		break;
    }
}
?>
