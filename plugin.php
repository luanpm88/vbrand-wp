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
function vbrand_remove_headers( $hook ) {
    // add script for custom iframe layouts inside acelle
    // wp_enqueue_style('vbrand_css');
    wp_enqueue_script('vbrand_js');

    // remove header for iframe inside acelle: admin
    header_remove('X-Frame-Options');
    header_remove('Content-Security-Policy');
}
add_action( 'admin_enqueue_scripts', 'vbrand_remove_headers' );

// auto login
function vbrand_auto_login( $hook ) {
    if ( defined( 'WP_ADMIN' ) ) {
        // WP auto login
        if (!is_user_logged_in()) {
            // ssss;
            $creds = array(
                'user_login'    => 'admin',
                'user_password' => 'admin',
                'remember'      => true
            );
            $user = wp_signon( $creds, false );
            if ( is_wp_error( $user ) ) {
                echo $user->get_error_message();die();
            }
            header("Refresh:0");
            die();
        }
    }    
}
add_action( 'init', 'vbrand_auto_login', 1 );

// remove header for iframe inside acelle: frontpage
add_filter( 'wp_headers', function($headers) {
    unset($headers['X-Frame-Options']);
	unset($headers['Content-Security-Policy']);
	return $headers;
}, 10000 );

// API
add_action( 'rest_api_init', function () {
    require_once('api.php');
} );