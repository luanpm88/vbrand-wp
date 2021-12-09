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

// iframe inside acelle config
function vbrand_enqueue_admin_script( $hook ) {
    // add script for custom iframe layouts inside acelle
    wp_enqueue_script( 'vbrand_enqueue_admin_script', '/vbrand/vbrand.js', array(), '1.0' );

    // remove header for iframe inside acelle
    header_remove('X-Frame-Options');
    header_remove('Content-Security-Policy');
}
add_action( 'admin_enqueue_scripts', 'vbrand_enqueue_admin_script' );