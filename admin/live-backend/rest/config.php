<?php

//Set the reporting

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED)); //except all that are notice or that are deprecated errors


class Config {
    public static function DB_NAME() {
        return Config::get_env("DB_NAME", "vetstation");
    }
    public static function DB_PORT() {
        return Config::get_env("DB_PORT", 3306);
    }
    public static function DB_USER() {
        return Config::get_env("DB_USER", 'root');
    }
    public static function DB_PASSWORD() {
        return Config::get_env("DB_PASSWORD", '');
    }
    public static function DB_HOST() {
        return Config::get_env("DB_HOST", '127.0.0.1');
    }
    public static function JWT_SECRET() {
        return Config::get_env("DB_HOST", 'eVbKrnRp6cLd0tayQyQH');
    }
    public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name]) != "" ? $_ENV[$name] : $default;
    }
}

//if env value with name that we set and if its value is not empty then
//return that variable
//if it is empty -> then return what is default in $default parameter


//if we call Config DB name it will call our static function get_env
//that will try to see inside in env variable
//env variable -> is variable tjhat is stored inside of pho server itself



//DB access credentials

//define('DB_NAME', 'vetstation');
//define('DB_PORT', 3306);
//define('DB_USER', 'root');
//define('DB_PASSWORD', '');
//define('DB_HOST', '127.0.0.1'); //localhost

//JWT Secret
//define('JWT_SECRET', 'eVbKrnRp6cLd0tayQyQH');