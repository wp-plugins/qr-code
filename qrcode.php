<?php
/*
Plugin Name: QR code widget
Description: It lets appear the QR-code of the given site in the slidebar
Author: Tomek
Author URI: http://wp-learning.net
Plugin URI: http://wp-learning.net
Version: 0.2
*/

add_action( 'widgets_init', 'qr_code' );
load_plugin_textdomain( 'qrcode', '', dirname( plugin_basename( __FILE__ ) ) . '/lang' );

function qr_code() {
	register_widget( 'WP_Widget_QR_Code' );
}

class WP_Widget_QR_Code extends WP_Widget {
function WP_Widget_QR_Code() {
	$widget_ops = array('classname' => 'widget_featured_entries', 'description' => __("It lets appear the QR-code of the given site in the slidebar", "qrcode") );
	$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'qr-code-widget' );
	$this->WP_Widget( 'qr-code-widget', __('QR code widget', 'qrcode'), $widget_ops, $control_ops );
}

	function widget( $args, $instance ) {
		extract( $args );
		$host = $_SERVER["HTTP_HOST"];
		$scheme = $_SERVER["REQUEST_SCHEME"];
		$url = $_SERVER["REQUEST_URI"];;;
		$full_url = $scheme."://".$host."/".$url;
		$title = apply_filters('widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
            echo "<center><img src='http://api.qrserver.com/v1/create-qr-code/?size=150x150&amp;data=".$full_url,"' width='150' height='150'></center>";
			echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('QR code widget', 'qrcode'));
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
	<?php
	}
}

?>