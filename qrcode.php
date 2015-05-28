<?php
/*
Plugin Name: QR Code
Description: It lets appear the QR-code of the given site in the slidebar
Author: Tomek
Author URI: http://wp-learning.net
Plugin URI: http://wp-learning.net
Version: 1.2
*/

add_action( 'widgets_init', 'qr_code' );
add_shortcode('qrcode','qrcode_shortcode');
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
		$title = apply_filters('widget_title', $instance['title'] );
		$url = $instance['url'];
		$size = $instance['size'];
		$margin = $instance['margin'];
		$before = $instance['before'];
		$after = $instance['after'];
		$sizes = $size.'x'.$size;
		echo $before_widget;
		if ( $before ) {
			$before = $before.'<br><br>';
		}
		if ( $after ) {
			$after = '<br><br>'.$after;
		}
		if ( $title )
			echo $before_title . $title . $after_title;
            echo "<center>".$before."<img src='http://api.qrserver.com/v1/create-qr-code/?size=$sizes&data=$url&margin=$margin' width='$size' height='$size'>".$after."</center>";
			echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['url'] = strip_tags( $new_instance['url'] );
		$instance['size'] = strip_tags( $new_instance['size'] );
		$instance['margin'] = strip_tags( $new_instance['margin'] );
		$instance['before'] = strip_tags( $new_instance['before'] );
		$instance['after'] = strip_tags( $new_instance['after'] );
		return $instance;
	}

	function form( $instance ) {
		if( $instance) {
			$title = esc_attr($instance['title']);
			$url = esc_attr($instance['url']);
			$size = esc_attr($instance['size']);
			$margin = esc_attr($instance['margin']);
			$before = esc_attr($instance['before']);
			$after = esc_attr($instance['after']);
		} else {
			$title =  __('QR code widget', 'qrcode');
			$url = get_bloginfo('url');
			$size = '150';
			$margin = '1';
			$before = '';
			$after = '';
		}
	?>
<p> 
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'qrcode'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /> 
</p> 
<p> 
<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('URL:', 'qrcode'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" /> 
</p> 
<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e('Size:', 'qrcode'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" type="text" value="<?php echo $size; ?>" /> 
</p> 
<p> 
<label for="<?php echo $this->get_field_id('margin'); ?>"><?php _e('Margin:', 'qrcode'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('margin'); ?>" name="<?php echo $this->get_field_name('margin'); ?>" type="text" value="<?php echo $margin; ?>" /> 
</p>
<p> 
<label for="<?php echo $this->get_field_id('before'); ?>"><?php _e('Text before image:', 'qrcode'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('before'); ?>" name="<?php echo $this->get_field_name('before'); ?>" type="text" value="<?php echo $before; ?>" /> 
</p>
<p> 
<label for="<?php echo $this->get_field_id('after'); ?>"><?php _e('Text after image:', 'qrcode'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('after'); ?>" name="<?php echo $this->get_field_name('after'); ?>" type="text" value="<?php echo $after; ?>" /> 
</p>
	<?php
	}
}

function qrcode_shortcode( $atts, $content = null ) {
    extract(shortcode_atts(array("url" => get_bloginfo('url'), "size" => "150", "margin" => "1", "before" => "", "after" => ""), $atts));
	$sizes = $size.'x'.$size;
	if ( $before ) {
		$before = $before.'<br>';
	}
	if ( $after ) {
		$after = '<br>'.$after;
	}
    echo "<div class='qrcode' style='text-align:center;'>".$before."<img src='http://api.qrserver.com/v1/create-qr-code/?size=$sizes&data=$url&margin=$margin' width='$size' height='$size'>".$after."</div>";
}
?>