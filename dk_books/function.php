<?php
/**
 * Hanldes the editprofile shortcode
 *
 * @author Tareq Hasan
 */

 define('DK_MANAGE_BOOK_URL', 'http://www.wonderbookland.com/manage-bookshelf');
 define('DK_BOOKSHELF_URL', 'http://www.wonderbookland.com/bookshelf');
 
function dk_book_permalink( $echo = true, $id = 0 ) {
    global $book, $wpdb;
    $options = get_option(NOW_READING_OPTIONS);

    if ( !empty($book) && empty($id) )
        $the_book = $book;
    elseif ( !empty($id) )
        $the_book = get_book(intval($id));

    if ( $the_book->id < 1 )
        return;

    $author = $the_book->nice_author;
    $title = $the_book->nice_title;

    $url = get_page_link(intval($_GET['page_id'])) . "?ig=ig&dkaction=view&now_reading_author=$author&amp;now_reading_title=$title";

    $url = apply_filters('book_permalink', $url);
    if ( $echo )
        echo $url;
    return $url;
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
add_shortcode( 'dk_profile_book', 'dk_profile_book' );//add manage shot code 

function dk_bookshelf(){
    require_once dirname(__FILE__) . '/templates/bookshelf_tpl.php';
}
add_shortcode( 'dk_bookshelf', 'dk_bookshelf' );//add bookshelf shot code 


function dk_jquery_scripts_method() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
    wp_enqueue_script( 'jquery' );
}    
 
add_action('wp_enqueue_scripts', 'dk_jquery_scripts_method');

function dk_jquery_ui_scripts_method() {
    wp_enqueue_script(
        'newscript',
        plugins_url('/js/jquery-ui.js', __FILE__),
        array('scriptaculous')
    );
}    
 
add_action('wp_enqueue_scripts', 'dk_jquery_ui_scripts_method');

function dk__main_scripts_method() {
    wp_enqueue_script(
        'newscript2',
        plugins_url('/js/dkmain.js', __FILE__),
        array('scriptaculous')
    );
}    
 
add_action('wp_enqueue_scripts', 'dk__main_scripts_method');

add_action( 'wp_enqueue_scripts', 'dk_add_my_stylesheet' );

function dk_add_my_stylesheet() {
        wp_register_style( 'dk-style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style( 'dk-style' );
    }

//show in userprofile
function dk_userprofile_book() {
	require_once dirname(__FILE__) . '/functions/manage_profilebook_fun.php';
	require_once dirname(__FILE__) . '/templates/manage_profilebook_tpl.php';
}


/**
 * Fetches books from the database based on a given query.
 *
 * Example usage:
 * <code>
 * $books = dk_get_books('status=reading&orderby=started&order=asc&num=-1&reader=user');
 * </code>
 * @param string $query Query string containing restrictions on what to fetch.
 *          Valid variables: $num, $status, $orderby, $order, $search, $author, $title, $reader.
 * @param bool show_private If true, will show all readers' private books!
 * @return array Returns a numerically indexed array in which each element corresponds to a book.
 */
function dk_mingle_show_user_books(){    global $userdata ;    $reader = "&reader=".$userdata->ID;    $books = dk_get_books("num=-1&status=all{$reader}");    ?>  <p  style="text-align:center" class="mngl-user-grid-header"><a href="<?php echo DK_BOOKSHELF_URL ; ?>"><?php _e('My bookshelf', 'mingle'); ?></a></p>    <?php}
function dk_get_books($query, $show_private = false) {

    global $wpdb;

    $options = get_option(NOW_READING_OPTIONS);

    parse_str($query);

    // We're fetching a collection of books, not just one.
    switch ( $status ) {
        case 'unread':
        case 'reading':
        case 'rcd':
        case 'nrecd':
        case 'beachr':
        case 'rainyr':
        case 'goodr':
        case 'comr':
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

    $order  = ( strtolower($order) == 'desc' ) ? 'DESC' : 'ASC';

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
        $offset = intval($offset);
        $num    = intval($num);
        $limit  = "LIMIT $offset, $num";
    } else
        $limit  = '';

    if ( !empty($author) ) {
        $author = $wpdb->escape($author);
        $author = "AND b_author = '$author'";
    }

    if ( !empty($title) ) {
        $title  = $wpdb->escape($title);
        $title  = "AND b_title = '$title'";
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
        $book->added = ( nr_empty_date($book->added) )  ? '' : $book->added;
        $book->started = ( nr_empty_date($book->started) )  ? '' : $book->started;
        $book->finished = ( nr_empty_date($book->finished) )    ? '' : $book->finished;
    }

    return $books;
}

?>