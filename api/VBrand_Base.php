<?php
 
class VBrand_Base extends WP_REST_Controller {
    public function authorize( $request ) {
        $token = $request['token'];

        // check api token
        $ch = curl_init("http://vbrand.com/validate-token/" . $token); // such as http://example.com/example.xml
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        $result = json_decode($data, true);
        curl_close($ch);

        if ($result['status'] !== 'success') {
            header("HTTP/1.1 401 Unauthorized");
            echo "Unauthorized!";
            exit;
        }
    }
}