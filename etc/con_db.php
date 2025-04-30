<?php
/** This file configures the maine DB connection **/
function db_connect()
{
    static $link;
    $link = mysqli_init();

    // Credentials and connection details should be set as environment variables
    $user     = getenv('DB_USER');      
    $pass     = getenv('DB_PASSWORD');  
    $database = getenv('DB_NAME');      
    $host     = getenv('DB_HOST');      
    $port     = getenv('DB_PORT');      

    // Attempt to connect
    $con = mysqli_real_connect($link, $host, $user, $pass, $database, (int)$port);

    if ($con === false) {
        // Handle error: log, alert, or return error message
        return mysqli_connect_error();
    }

    mysqli_set_charset($link, 'utf8');
    return $link;
}

$con = db_connect();

if (!defined('__DB_ROOT__')) {
    define('__DB_ROOT__', dirname(dirname(__FILE__)));
}

require_once(__DB_ROOT__ . "/libnb/php/db_utils.php");
