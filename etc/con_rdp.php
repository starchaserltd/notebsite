<?php
/**
 * This file is for remote DB connection
 * Single-file “read” DB connection example.
 *
 * IMPORTANT:
 *  - The credentials below are only for example purposes.
 *  - Before deploying, replace the example values with your real credentials.
 *  - Never commit real passwords or hosts to source control.
 */

/* ──────────────────────────────────────────────────────
   Example credentials (replace these!):
────────────────────────────────────────────────────── */
define('DB_RUSER',     'example_read_user');        
define('DB_RPASSWORD', 'example_read_pass@123');    
define('DB_RNAME',     'example_database');         
define('DB_RHOST',     '203.0.113.5');              
define('DB_RPORT',     '13306');
/* ────────────────────────────────────────────────────── */

function db_rconnect()
{
    static $link;
    $link = mysqli_init();

    // Ensure the constants are set
    if (!defined('DB_RUSER')   || !defined('DB_RPASSWORD')
     || !defined('DB_RNAME')   || !defined('DB_RHOST')
     || !defined('DB_RPORT')) {
        trigger_error('Read-DB configuration constants not set', E_USER_ERROR);
    }

    // Attempt to connect
    $success = mysqli_real_connect(
        $link,
        DB_RHOST,
        DB_RUSER,
        DB_RPASSWORD,
        DB_RNAME,
        (int)DB_RPORT
    );

    if ($success === false) {
        // Connection failed: return error message (or handle as needed)
        return mysqli_connect_error();
    }

    return $link;
}

// Establish the read connection
$rcon = db_rconnect();

// Define project root if not already
if (!defined('__DB_ROOT__')) {
    define('__DB_ROOT__', dirname(dirname(__FILE__)));
}

// Include your DB utilities
require_once(__DB_ROOT__ . "/libnb/php/db_utils.php");
