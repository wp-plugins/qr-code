<?php
/*
Plugin Name: QR Code
Description: It lets appear the QR-code of the given site in the slidebar
Author: Tomek
Author URI: http://wp-learning.net
Plugin URI: http://wp-learning.net
Version: 1.1
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
		$width = $instance['width'];
		$height = $instance['height'];
		$color = $instance['color'];
		$bgcolor = $instance['bgcolor'];
		$margin = $instance['margin'];
		$before = $instance['before'];
		$after = $instance['after'];
		$size = $width.'x'.$height;
		echo $before_widget;
		if ( $before ) {
			$before = $before.'<br><br>';
		}
		if ( $after ) {
			$after = '<br><br>'.$after;
		}
		if ( $title )
			echo $before_title . $title . $after_title;
            echo "<center>".$before."<img src='http://api.qrserver.com/v1/create-qr-code/?size=$size&amp;data=$url&color=$color&bgcolor=$bgcolor&margin=$margin' width='$width' height='$height'>".$after."</center>";
			echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['url'] = strip_tags( $new_instance['url'] );
		$instance['width'] = strip_tags( $new_instance['width'] );
		$instance['height'] = strip_tags( $new_instance['height'] );
		$instance['color'] = strip_tags( $new_instance['color'] );
		$instance['bgcolor'] = strip_tags( $new_instance['bgcolor'] );
		$instance['margin'] = strip_tags( $new_instance['margin'] );
		$instance['before'] = strip_tags( $new_instance['before'] );
		$instance['after'] = strip_tags( $new_instance['after'] );
		return $instance;
	}

	function form( $instance ) {
		if( $instance) {
			$title = esc_attr($instance['title']);
			$url = esc_attr($instance['url']);
			$width = esc_attr($instance['width']);
			$height = esc_attr($instance['height']);
			$color = esc_attr($instance['color']);
			$bgcolor = esc_attr($instance['bgcolor']);
			$margin = esc_attr($instance['margin']);
			$before = esc_attr($instance['before']);
			$after = esc_attr($instance['after']);
		} else {
			$title =  __('QR code widget', 'qrcode');
			$url = get_bloginfo('url');
			$width = '150';
			$height = '150';
			$color = 'ffffff';
			$bgcolor = '000000';
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
<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:', 'qrcode'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" /> 
</p> 
<p> 
<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:', 'qrcode'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" /> 
</p>
<p> 
<label for="<?php echo $this->get_field_id('color'); ?>"><?php _e('Foreground Color (without double-cross):', 'qrcode'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>" type="text" value="<?php echo $color; ?>" /> 
</p>
<p> 
<label for="<?php echo $this->get_field_id('bgcolor'); ?>"><?php _e('Background Color (without double-cross):', 'qrcode'); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id('bgcolor'); ?>" name="<?php echo $this->get_field_name('bgcolor'); ?>" type="text" value="<?php echo $bgcolor; ?>" /> 
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
    extract(shortcode_atts(array("url" => get_bloginfo('url'), "width" => "150", "height" => "150", "color" => "ffffff", "bgcolor" => "000000", "margin" => "1", "before" => "", "after" => ""), $atts));
	$size = $width.'x'.$height;
	if ( $before ) {
		$before = $before.'<br>';
	}
	if ( $after ) {
		$after = '<br>'.$after;
	}
    echo "<div class='qrcode' style='width:ßwidth;height:$height;text-align:center;'>".$before."<img src='http://api.qrserver.com/v1/create-qr-code/?size=$size&amp;data=$url&color=$color&bgcolor=$bgcolor&margin=$margin' width='$width' height='$height'>".$after."</div>";
}
?>