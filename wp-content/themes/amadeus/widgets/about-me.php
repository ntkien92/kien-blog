<?php
/**
 * About widget
 *
 * @package Amadeus
 */

/**
 * Class Amadeus_About
 */
class Amadeus_About extends WP_Widget {

	/**
	 * Amadeus_About constructor.
	 */
	public function __construct() {
		$widget_ops  = array( 'classname' => 'amadeus_about', 'description' => __( 'About me widget.', 'amadeus' ) );
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'amadeus_about', __( 'Amadeus: About me', 'amadeus' ), $widget_ops, $control_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {

		$title     = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$image_url = isset( $instance['image_url'] ) ? esc_url( $instance['image_url'] ) : '';
		$text      = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );

		if ( ! empty( $args['before_widget'] ) ) {
			echo $args['before_widget'];
		}

		if ( ! empty( $image_url ) ) {
			echo '<div class="photo-wrapper"><img class="about-photo" src="' . $image_url . '"/></div>';
		}
		if ( ! empty( $title ) ) {

			if ( ! empty( $args['before_title'] ) ) {
				echo $args['before_title'];
			}
			echo $title;

			if ( ! empty( $args['after_title'] ) ) {
				echo $args['after_title'];
			}
		} ?>
		<div class="textwidget"><?php echo ! empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
		<?php

		if ( ! empty( $args['after_widget'] ) ) {
			echo $args['after_widget'];
		}
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options.
	 * @param array $old_instance The previous options.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']     = strip_tags( $new_instance['title'] );
		$instance['image_url'] = esc_url_raw( $new_instance['image_url'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed
		}
		$instance['filter'] = isset( $new_instance['filter'] );

		return $instance;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options.
	 */
	public function form( $instance ) {
		$instance  = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'image_url' => '' ) );
		$title     = strip_tags( $instance['title'] );
		$text      = esc_textarea( $instance['text'] );
		$image_url = esc_url( $instance['image_url'] );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'amadeus' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/></p>

		<p><label for="<?php echo $this->get_field_id( 'image_url' ); ?>"><?php _e( 'Enter the URL for your photo', 'amadeus' ); ?></label>
			<input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'image_url' ); ?>" name="<?php echo $this->get_field_name( 'image_url' ); ?>" type="text" value="<?php echo esc_url( $image_url ); ?>" size="3"/></p>

		<p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Add your text:', 'amadeus' ); ?></label>
			<textarea class="widefat" rows="10" cols="16" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id( 'filter' ); ?>" name="<?php echo $this->get_field_name( 'filter' ); ?>" type="checkbox" <?php checked( isset( $instance['filter'] ) ? $instance['filter'] : 0 ); ?> />&nbsp;<label
					for="<?php echo $this->get_field_id( 'filter' ); ?>"><?php _e( 'Automatically add paragraphs', 'amadeus' ); ?></label></p>
		<?php
	}
}
