<?php
/**
 * Adds Foo_Widget widget.
 */
class FB_Twitter_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'fb_twitter_widget', // Base ID
			__( 'Twitter Widget', 'text_domain' ), // Name
			array( 'description' => __( 'A custom Twitter timeline widget by Fred Bradley', 'text_domain' ), ) // Args
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
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		$arg = (object)$instance;
		echo do_shortcode("[emaptweet div_id=\"".$arg->div_id."\" js_function=\"".$arg->js_function."\" timeline_id=\"".$arg->timeline_id."\" num_tweets=\"".$arg->num_tweets."\"]");
		echo __( 'Hello, World!', 'text_domain' );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		foreach ($this->fields() as $field):
			$field = (object)$field;
			$esc_value = ! empty( $instance[$field->id] ) ? $instance[$field->id] : __( $field->value, 'text_domain' );


		?>
		
		<p>
		<label for="<?php echo $this->get_field_id( $field->id ); ?>"><?php _e( $field->title.' :' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( $field->id ); ?>" name="<?php echo $this->get_field_name( $field->id ); ?>" type="text" value="<?php echo esc_attr( $esc_value ); ?>">
		<span><?php echo $field->desc; ?></span>
		</p>
		
		<?php endforeach; 
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
		foreach ($this->fields() as $field):
			$field = (object)$field;
			$instance[$field->id] = ( ! empty( $new_instance[$field->id] ) ) ? strip_tags( $new_instance[$field->id] ) : '';
		endforeach;
		return $instance;
	}
	
	/**
	 * form_field function.
	 * A helper function written by Fred to help streamline the widget making process
	 * 
	 * @access private
	 * @param mixed $id
	 * @param mixed $title
	 * @param mixed $value
	 * @param mixed $description (default: null)
	 * @return void
	 */
	private function form_field($id, $title, $value, $description=null) {
		return array(
			"id" => $id, 
			"title" => $title,
			"value" => $value,
			"desc" => $description
		);
	}
	
	
	/**
	 * fields function.
	 * A helper function written by Fred to help streamline the widget making process
	 * 
	 * @access private
	 * @return void
	 */
	private function fields() {
		$array = array(
			$this->form_field("title", "Title", "Follow Us on Twit Twit", "Here is a desc"),
			$this->form_field("js_function", "Javascript Function", "showtweet"),
			$this->form_field("num_tweets", "# Tweets", 3, "# of Tweets of Pull"),
			$this->form_field("timeline_id", "Twitter Timeline ID", "2490909"),
			$this->form_field("div_id", "DIV ID", "emaptweet", "The ID of the Div you wish to populate")
		);
		return $array;
	}

}