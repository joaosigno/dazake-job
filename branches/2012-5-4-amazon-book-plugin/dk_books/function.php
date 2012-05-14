<?php
/**
 * Hanldes the editprofile shortcode
 *
 * @author Tareq Hasan
 */

/**
 * Fetches books from the database based on a given query.
 *
 * Example usage:
 * <code>
 * $books = get_books('status=reading&orderby=started&order=asc&num=-1&reader=user');
 * </code>
 * @param string $query Query string containing restrictions on what to fetch.
 * 		 	Valid variables: $num, $status, $orderby, $order, $search, $author, $title, $reader.
 * @param bool show_private If true, will show all readers' private books!
 * @return array Returns a numerically indexed array in which each element corresponds to a book.
 */

function dk_get_books($query, $show_private = false) {

    global $wpdb;

    $options = get_option(NOW_READING_OPTIONS);

    parse_str($query);

    // We're fetching a collection of books, not just one.
    switch ( $status ) {
        case 'unread':
        case 'onhold':
        case 'reading':
        case 'rcommend':
        case 'nrecommend':
        case 'beachr':
        case 'rainyr':
        case 'goodr':
        case 'commuter':
        case 'pastr':
            break;
        default:
            $status = 'all';
            break;
    }
    if ( $status != 'all' )
        $status = "AND b_status = '$status'";
    else
        $status = '';

    if ( !empty($search) ) {
        $search = $wpdb->escape($search);
        $search = "AND ( b_author LIKE '%$search%' OR b_title LIKE '%$search%' OR m_value LIKE '%$search%')";
    } else
        $search = '';

    $order	= ( strtolower($order) == 'desc' ) ? 'DESC' : 'ASC';

    switch ( $orderby ) {
        case 'added':
            $orderby = 'b_added';
            break;
        case 'started':
            $orderby = 'b_started';
            break;
        case 'finished':
            $orderby = 'b_finished';
            break;
        case 'title':
            $orderby = 'b_title';
            break;
        case 'author':
            $orderby = 'b_author';
            break;
        case 'asin':
            $orderby = 'b_asin';
            break;
        case 'status':
            $orderby = "b_status $order, b_added";
            break;
        case 'rating':
            $orderby = 'b_rating';
            break;
        case 'random':
            $orderby = 'RAND()';
            break;
        default:
            $orderby = 'b_added';
            break;
    }

    if ( $num > -1 && $offset >= 0 ) {
        $offset	= intval($offset);
        $num 	= intval($num);
        $limit	= "LIMIT $offset, $num";
    } else
        $limit	= '';

    if ( !empty($author) ) {
        $author	= $wpdb->escape($author);
        $author	= "AND b_author = '$author'";
    }

    if ( !empty($title) ) {
        $title	= $wpdb->escape($title);
        $title	= "AND b_title = '$title'";
    }

    if ( !empty($tag) ) {
        $tag = $wpdb->escape($tag);
        $tag = "AND t_name = '$tag'";
    }

    $meta = '';
    if ( !empty($meta_key) ) {
        $meta_key = $wpdb->escape($meta_key);
        $meta = "AND meta_key = '$meta_key'";
        if ( !empty($meta_value )) {
            $meta_value = $wpdb->escape($meta_value);
            $meta .= " AND meta_value = '$meta_value'";
        }
    }

	$reader = get_reader_visibility_filter($reader, $show_private);

    $query = "
	SELECT
		COUNT(*) AS count,
		b_id AS id, b_title AS title, b_author AS author, b_image AS image, b_status AS status, b_nice_title AS nice_title, b_nice_author AS nice_author,
		b_added AS added, b_started AS started, b_finished AS finished,
		b_asin AS asin, b_rating AS rating, b_review AS review, b_post AS post, b_reader as reader, b_post_op as post_op
	FROM
        {$wpdb->prefix}now_reading
	LEFT JOIN {$wpdb->prefix}now_reading_meta
		ON m_book = b_id
	LEFT JOIN {$wpdb->prefix}now_reading_books2tags
		ON book_id = b_id
	LEFT JOIN {$wpdb->prefix}now_reading_tags
		ON tag_id = t_id
	WHERE
		1=1
        $status
        $id
        $search
        $author
        $title
        $tag
        $meta
	AND
        $reader
	GROUP BY
		b_id
	ORDER BY
        $orderby $order
        $limit
        ";
	$books = $wpdb->get_results($query);

    $books = apply_filters('get_books', $books);

    foreach ( (array) $books as $book ) {
        $book->added = ( nr_empty_date($book->added) )	? '' : $book->added;
        $book->started = ( nr_empty_date($book->started) )	? '' : $book->started;
        $book->finished = ( nr_empty_date($book->finished) )	? '' : $book->finished;
    }

    return $books;
}


function dk_profile_book() {
	// if(empty($_GET['added'])){
		switch ($_GET['dkaction']) {
			case 'manage':
				require_once dirname(__FILE__) . '/functions/manage_book_fun.php';
				require_once dirname(__FILE__) . '/templates/manage_book_tpl.php';
				break;
			case 'edite':
				require_once dirname(__FILE__) . '/functions/edite_book_fun.php';
				break;
			case 'library':
				require_once dirname(__FILE__) . '/functions/library_book_fun.php';
				break;	
			case 'show':
				require_once dirname(__FILE__) . '/functions/show_book_fun.php';
				break;	
			case 'view':
				require_once dirname(__FILE__) . '/functions/view_book_fun.php';
				break;	
				break;	
			case 'add':
				require_once dirname(__FILE__) . '/functions/add_book_fun.php';
				require_once dirname(__FILE__) . '/templates/add_book_tpl.php';
				break;	
			default:
				require_once dirname(__FILE__) . '/functions/manage_book_fun.php';
				require_once dirname(__FILE__) . '/templates/manage_book_tpl.php';
				break;
		}
	// }
}

add_shortcode( 'dk_profile_book', 'dk_profile_book' );

function dazake_load_script() {
	if (!is_admin()) {
		/**
		 * load stylesheet
		 */
		wp_enqueue_style( 'bootstrap', plugins_url( 'dk_books/css/style.css' , dirname(__FILE__) ) );
	}
}
add_action('init', 'dazake_load_script');

//show in userprofile
function dk_userprofile_book() {
	require_once dirname(__FILE__) . '/functions/manage_profilebook_fun.php';
	require_once dirname(__FILE__) . '/templates/manage_profilebook_tpl.php';
}
?>