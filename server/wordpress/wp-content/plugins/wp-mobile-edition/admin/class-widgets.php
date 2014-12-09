<?php
// Creating the widget
class FDX_Widget_1 extends WP_Widget {

function __construct() {
parent::__construct(
'fdx_widget1', // widget ID
__('QR-Code | Switcher Link', 'wp-mobile-edition'), // Widget name
array( 'description' => __( 'A QR-Code used for navigating to a mobile URL. A link that allows users to toggle between desktop and mobile sites.', 'wp-mobile-edition' ), ) // Widget description
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];
// This is where you run the code and display the output
$size = $instance['size'];
$urlink = $instance['urlink'];

if (trim($urlink)=='') {

   if (is_home()){
   $urlink = get_home_url();
   } else {
   $urlink = wp_get_shortlink();
   }
}

$url = "http://chart.apis.google.com/chart?chs=" .
         $size . "x" . $size .
         "&amp;cht=qr&amp;choe=UTF-8&amp;chl=" .
         urlencode($urlink);
echo "<div style='text-align: center'><img width='$size' height='$size' src='$url' alt='[QR-Code]' /><br>";
echo do_shortcode('[fdx-switch-link]') ."</div>" ;

echo $args['after_widget'];
}

// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Our Mobile Site', 'wp-mobile-edition' );
}

if ( isset( $instance[ 'size' ] ) ) {
$size = $instance[ 'size' ];
}
else {
$size = '150';
}

if ( isset( $instance[ 'urlink' ] ) ) {
$urlink = $instance[ 'urlink' ];
}
else {
$urlink = get_home_url();
}




// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'QR-Code Size','wp-mobile-edition') ; ?> <small><em>(<?php _e('pixels', 'wp-mobile-edition'); ?>)</em></small>:</label>
<input class="widefat" id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" type="text" value="<?php echo esc_attr( $size ); ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id( 'urlink' ); ?>"><?php _e( 'QR-Code URL','wp-mobile-edition') ; ?> :</label>
<input class="widefat" id="<?php echo $this->get_field_id( 'urlink' ); ?>" name="<?php echo $this->get_field_name( 'urlink' ); ?>" type="text" value="<?php echo esc_attr( $urlink ); ?>" /><br>
 <small><em><?php _e('If you leave this blank, the URL in the barcode will be dynamic, and will be the mobile equivalent of the actual page the user is on.', 'wp-mobile-edition'); ?></em></small>
</p>

<?php
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['size'] = ( ! empty( $new_instance['size'] ) ) ? strip_tags( $new_instance['size'] ) : '';
$instance['urlink'] = ( ! empty( $new_instance['urlink'] ) ) ? strip_tags( $new_instance['urlink'] ) : '';
return $instance;
}
} // Class wpb_widget ends here
