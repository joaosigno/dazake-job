<?php
/**
 * Adds Foo_Widget widget.
 */
class Dk_blogger_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'dk_blogger_widget', // Base ID
			'Dk_blogger_Widget', // Name
			array( 'description' => __( 'DK Blogger List Show', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		//get blogger users
		$wp_user_search = new WP_User_Query( array( 'role' => 'Contributor' ) );
		$subscriber = $wp_user_search->get_results();

		//get post results 
		global $wpdb ;
		$str = "SELECT * FROM `{$wpdb->prefix}posts`, {$wpdb->prefix}users where {$wpdb->prefix}posts.post_author = {$wpdb->prefix}users.ID and  {$wpdb->prefix}posts.post_type = 'post' group by {$wpdb->prefix}posts.post_author order by  {$wpdb->prefix}posts.post_date";
		$result = $wpdb->get_results($str);

		//if set rand .rand echo 
		$dk_bloger_list_order = get_option('dk_bloger_list_order');

		if($dk_bloger_list_order == 'random')
			shuffle($result);

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		$dk_bloger_list_num = get_option('dk_bloger_list_num');
		$count = 0;
		?>
		<div id = "dk_widget_blogger_boxs" >
			<?php foreach($result as $key => $value) : ?>
			<?php 
				
				$flag = 'false';
				foreach ($subscriber as $user) {
					if($user->ID == $value->post_author){
						$flag = 'true';
						$count ++ ;
					}
				}


				$userimage = get_user_option( 'dk_blogger_image', $value->post_author);
				query_posts('author=' . $value->post_author);
			?>
			<?php if($flag == 'true' && ($count<= $dk_bloger_list_num) ):?>
				
				<div class="dk_widget_blogger_inner">
					<div class="dk_widget_blogger_last_post">
					<?php 
						if ( have_posts() ) : while ( have_posts() ) : the_post();
							the_title();
						endwhile; else:
							echo "The user has not contributed anything!";
						endif;
					?>
					</div>
					<div class="dk_widget_blogger_head_img_n_name">
						<a href ='<?php the_permalink() ;?>' ?>
						<img height=60px width=64px src="<?php echo $userimage ;?>" alt="">
						<span class = "dk_widget_blogger_name" ><?php echo $value->user_nicename;?></span>
						</a>
					</div>
				</div>
			<?php endif;?>
			<?php endforeach;?>
		</div>



		<?php
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

} // class Foo_Widget


// register Foo_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "dk_blogger_widget" );' ) );


?>