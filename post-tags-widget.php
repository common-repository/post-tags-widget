<?php

/*
Plugin Name: Post Tags Widget
Plugin URI: https://wordpress.org/plugins/post-tags-widget
Description: Display tags for the current post in a widget.
Version: 1.0
Author: Jeff Farthing
Author URI: https://jfarthing.com
Text Domain: post-tags-widget
*/

/**
 * The Post Tags Widget class.
 *
 * @since 1.0
 */
class Post_Tags_Widget extends WP_Widget {
	/**
	 * Create a new instance.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		parent::__construct( 'post-tags-widget', __( 'Post Tags', 'post-tags-widget' ), array(
			'description' => __( 'Displays tags for the current post.', 'post-tags-widget' ),
		) );
	}

	/**
	 * Render the widget.
	 *
	 * @since 1.0
	 *
	 * @param array $args The display arguments.
	 * @param array $instance The instance options.
	 */
	public function widget( $args, $instance ) {

		if ( ! is_singular() ) {
			return;
		}

		if ( ! has_tag() ) {
			return;
		}

		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Post Tags', 'post-tags-widget' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		the_tags( '' );

		echo $args['after_widget'];
	}

	/**
	 * Process the widget options form.
	 *
	 * @since 1.0
	 *
	 * @param array $new_instance The new instance options.
	 * @param array $old_instance The old instance options.
	 * @return array The updated instance options.
	 */
	public function update( $new_instance, $old_instance ) {
		return wp_parse_args( array(
			'title' => sanitize_text_field( $new_instance['title'] ),
		), $old_instance );
	}

	/**
	 * Render the widget options form.
	 *
	 * @since 1.0
	 *
	 * @param array $instance The instance options.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
		) );

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'post-tags-widget' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<?php
	}

	/**
	 * Register the widget.
	 *
	 * @since 1.0
	 */
	public static function register() {
		register_widget( 'Post_Tags_Widget' );
	}
}
add_action( 'widgets_init', 'Post_Tags_Widget::register' );
