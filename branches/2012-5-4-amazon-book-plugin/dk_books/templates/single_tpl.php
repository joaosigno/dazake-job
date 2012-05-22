<?php

	$id = intval($_GET['id']);
            $existing = get_book($id);
            $meta = get_book_meta($existing->id);
            $tags = join(get_book_tags($existing->id), ',');

            echo '
			<div class="wrap dk_single">
				<h2>' . __("Edit book", NRTD) . '</h2>
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
						' . $existing->title . '
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
						' . $existing->author . '
					</td>
				</tr>
				';


			// Status.
            echo '
				<tr class="form-field">
					<th valign="top" scope="row">
						<label for="status-0">' . __("Status", NRTD) . '</label>
					</th>
					<td>'.$existing->status.'</td>
				</tr>';
			// Rating.
            echo '
				<tr class="form-field">
					<th valign="top" scope="row">
						<label for="rating[]"><label for="rating">' . __("Rating", NRTD) . '</label></label>
					</th>
					<td>'.$existing->rating.'</td>
				</tr>
				';

			// Review.
            echo '
				<tr class="form-field">
					<th valign="top" scope="row">
						<label for="review-0">' . __("Review", NRTD) . '</label>
					</th>
					<td><p>' . htmlentities($existing->review, ENT_QUOTES, "UTF-8") . '</p>
					</td>
				</tr>

				</tbody>
				</table>
				</form>

			</div>


			';
?>