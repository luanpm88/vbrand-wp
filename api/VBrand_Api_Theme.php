<?php
 
class VBrand_Api_Theme extends VBrand_Base {
    public function register_routes() {
        $version = '1';
        $namespace = 'vbrand/v' . $version;
        $base = 'themes';
        register_rest_route( $namespace, '/' . $base, array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_themes' ),
                'args'                => array(
        
                ),
            ),
        ));
    }

    public function get_themes( $request ) {
        $this->authorize( $request );

        require_once ABSPATH . '/wp-admin/includes/admin.php';
        echo json_encode(wp_prepare_themes_for_js());
    }
}