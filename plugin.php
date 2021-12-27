<?php
/**
 * @wordpress-plugin
 * Plugin Name:       vBrand WP
 * Plugin URI:        https://acellemail.com/
 * Description:       A plugin.
 * Version:           1.0
 * Author:            Acelle Team @ Basic Technology
 * Author URI:        https://acellemail.com/
 */

// register jquery and style on initialization
function vbrand_register_script() {
    wp_register_script( 'vbrand_js', plugins_url('/assets/vbrand.js', __FILE__), array('jquery'), '2.5.1' );
    wp_register_style( 'vbrand_css', plugins_url('/assets/vbrand.css', __FILE__), false, '1.0.0', 'all');
}
add_action('init', 'vbrand_register_script');

// iframe inside acelle config
function vbrand_enqueue_admin_script( $hook ) {
    // WP auto login
    if (!is_user_logged_in()) {
        $creds = array(
            'user_login'    => 'admin',
            'user_password' => 'admin',
            'remember'      => true
        );
        $user = wp_signon( $creds, false );
        header("Refresh:0");
    }

    // add script for custom iframe layouts inside acelle
    // wp_enqueue_style('vbrand_css');
    wp_enqueue_script('vbrand_js');

    // remove header for iframe inside acelle: admin
    header_remove('X-Frame-Options');
    header_remove('Content-Security-Policy');
}
add_action( 'admin_enqueue_scripts', 'vbrand_enqueue_admin_script' );

// remove header for iframe inside acelle: frontpage
add_filter( 'wp_headers', function($headers) {
    unset($headers['X-Frame-Options']);
	unset($headers['Content-Security-Policy']);
	return $headers;
}, 10000 );

// Creating the widget 
class wpb_widget extends WP_Widget {
 
    function __construct() {
    parent::__construct(
     
    // Base ID of your widget
    'wpb_widget', 
     
    // Widget name will appear in UI
    __('vBrand Test Widget', 'wpb_widget_domain'), 
     
    // Widget description
    array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), ) 
    );
    }
     
    // Creating widget front-end
     
    public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
     
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
     
    // This is where you run the code and display the output
    echo __( 'Hello, World!', 'wpb_widget_domain' );
    echo $args['after_widget'];
    }
             
    // Widget Backend 
    public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
    }
    else {
    $title = __( 'New title', 'wpb_widget_domain' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php 
    }
         
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
    }
    
    // Class wpb_widget ends here
    }


    // register: trans file here: wp-content/languages/plugins/my-theme-en_US.mo
    add_action( 'init', 'wpdocs_load_textdomain' );
 
    function wpdocs_load_textdomain() {
        load_plugin_textdomain( 'my-theme', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
    }

    // Register and load the widget
    function wpb_load_widget() {
        register_widget( 'wpb_widget' );
    }
    add_action( 'widgets_init', 'wpb_load_widget' );


    // echo '-----------------------------------' . __('Hello Plugin', 'my-theme') . ' : ' . get_locale();