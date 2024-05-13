<?php

require  './vendor/autoload.php';
require './rest/routes/user_routes.php';
require './rest/routes/vet_routes.php';
require './rest/routes/pet_routes.php';
require './rest/routes/station_routes.php';
require './rest/routes/appointment_routes.php';
require './rest/routes/auth_routes.php';


/*
Flight::route('/', function () {
    echo 'hello world!';
  });

  //we can use aditional route here

Flight::route('/web', function () {
    echo 'hello world - web!';
  });
*/
  Flight::start();