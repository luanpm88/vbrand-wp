<?php

require_once('api/VBrand_Base.php');
require_once('api/VBrand_Api_Theme.php');

// Register Theme Api
$themeApi = new VBrand_Api_Theme();
$themeApi->register_routes();