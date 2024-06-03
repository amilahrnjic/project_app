<?php

require __DIR__ . '/../../../vendor/autoload.php';


if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'){
    define('BASE_URL', 'http://localhost/project_final/admin/live-backend/');
} else {
    define('BASE_URL', 'https://sea-turtle-app-l52v8.ondigitalocean.app/admin/live-backend/');
}


//define('BASE_URL', 'http://localhost/project_final/admin/live-backend/');

error_reporting(0);

$openapi = \OpenApi\Generator::scan(['../../../rest/routes', './']);
header('Content-Type: application/x-yaml');
echo $openapi->toYaml();
?>
