<?php
/** This file configures the maine DB connection **/
function db_connect()
{
    static $link;
    $link = mysqli_init();

    // Credentials and connection details should be set as environment variables
    $user     = getenv('DB_USER');      // e.g. 'notebro_db'
    $pass     = getenv('DB_PASSWORD');  // e.g. 'nBdBnologin&4'
    $database = getenv('DB_NAME');      // e.g. 'notebro_db'
    $host     = getenv('DB_HOST');      // e.g. '172.31.13.210'
    $port     = getenv('DB_PORT');      // e.g. '3306'

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
