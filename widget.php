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
		echo do_shortcode("[fb_twitter_widget 
			div_id=\"".$arg->div_id."\" 
			js_function=\"".$arg->js_function."\" 
			timeline_id=\"".$arg->timeline_id."\" 
			num_tweets=\"".$arg->num_tweets."\" 
			show_images=\"".$arg->show_images."\" 
			hide_timestamp=\"".$arg->hide_timestamp."\" 
			show_user=\"".$arg->show_user."\" 
			show_links=\"".$arg->show_links."\" 
			hide_rts=\"".$arg->hide_rts."\"
			hide_interaction=\"".$arg->hide_interaction."\" 
			]");
		echo $args['after_widget'];
	}


	public function bool_options() {
		return array(
			"Yes" => 1,
			"No" => 0
		);
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
			if ($field->type == "bool"):
			?>
			<p>
		<label for="<?php echo $this->get_field_id( $field->id ); ?>"><?php _e( $field->title.' :' ); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id($field->id); ?>" name="<?php echo $this->get_field_name($field->id); ?>">
			<option value="">--Please Select--</option>
			<?php 
				foreach ($this->bool_options() as $option => $value):
					if ($value==esc_attr($esc_value)):
						$sel = "selected=\"selected\"";
					else:
						$sel = "";
					endif;			?>
			<option value="<?php echo $value; ?>" <?php echo $sel; ?>><?php echo $option; ?></option>
			<?php endforeach; ?>
		</select>
		<span><?php echo $field->desc; ?></span>
		</p>

			<?php
			else:
		?>
		
		<p>
		<label for="<?php echo $this->get_field_id( $field->id ); ?>"><?php _e( $field->title.' :' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( $field->id ); ?>" name="<?php echo $this->get_field_name( $field->id ); ?>" type="text" value="<?php echo esc_attr( $esc_value ); ?>">
		<span><?php echo $field->desc; ?></span>
		</p>
		
		<?php endif;
			endforeach; 
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
			if ($field->type === "bool"):
				(bool)$instance[$field->id] = ( ! empty( $new_instance[$field->id] ) ) ? strip_tags( $new_instance[$field->id] ) : '';
			else:
				$instance[$field->id] = ( ! empty( $new_instance[$field->id] ) ) ? strip_tags( $new_instance[$field->id] ) : '';
			endif;
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
	private function form_field($type, $id, $title, $value, $description=null) {
		return array(
			"type" => $type,
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
			$this->form_field("text","title", "Title", "Follow Us on Twit Twit", "Here is a desc"),
			$this->form_field("text","js_function", "Javascript Function", "showtweet"),
			$this->form_field("text","num_tweets", "# Tweets", 3, "# of Tweets of Pull"),
			$this->form_field("text","timeline_id", "Twitter Timeline ID", "2490909"),
			$this->form_field("text","div_id", "DIV ID", "emaptweet", "The ID of the Div you wish to populate"),
			$this->form_field("bool","show_user", "Show User", false),
			$this->form_field("bool","show_links", "Show Links", false),
			$this->form_field("bool","hide_rts", "Hide Retweets", false),
			$this->form_field("bool","hide_interaction", "Hide Interaction Buttons", false),
			$this->form_field("bool","hide_timestamp", "Hide Timestamp", false),
			$this->form_field("bool","show_images", "Show Images Inline", false),
		);
		return $array;
	}

}
