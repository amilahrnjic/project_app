<?php

//Set the reporting

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED)); //except all that are notice or that are deprecated errors

//DB access credentials

define('DB_NAME', 'vetstation');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', '127.0.0.1'); //localhost

//JWT Secret
define('JWT_SECRET', 'eVbKrnRp6cLd0tayQyQH');