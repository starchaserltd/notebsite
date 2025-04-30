<?php
/**
 * This file configures the Search DB connection
 * Single-file “sharded” DB connection example.
 *
 * IMPORTANT:
 *  - The credentials below are only for example purposes.
 *  - Before deploying, replace the example values with your real credentials.
 *  - Never commit real passwords or hosts to source control.
 */

/* ──────────────────────────────────────────────────────
   Example credentials (replace these!):
────────────────────────────────────────────────────── */
define('DB_SUSER',     'example_sdb_user');       // e.g. 'notebro_sdb'
define('DB_SPASSWORD', 'example_sdb_pass@123');   // e.g. 'nBdBnologinsdb2'
define('DB_SNAME',     'example_database');       // e.g. 'notebro_temp'
define('DB_SPORT',     '3306');                   // e.g. '3306'
/* ────────────────────────────────────────────────────── */

function dbs_connect($return_con_data = false)
{
    static $link;
    $link = mysqli_init();

    // Ensure the constants are set
    if (!defined('DB_SUSER') || !defined('DB_SPASSWORD')
     || !defined('DB_SNAME') || !defined('DB_SPORT')) {
        trigger_error('Sharded-DB configuration constants not set', E_USER_ERROR);
    }

    // Read server list from file (one host per line, space-separated if needed)
    $lines = file('/var/www/noteb/etc/sservers', FILE_SKIP_EMPTY_LINES);
    $servers = [];
    foreach ($lines as $line) {
        // normalize whitespace and split
        $parts = preg_split('/\s+/', trim($line));
        if (count($parts) > 1) {
            // skip label in first position if present
            array_shift($parts);
        }
        $servers = array_merge($servers, $parts);
    }

    if (empty($servers)) {
        trigger_error('No database hosts found in sservers file', E_USER_ERROR);
    }

    // Pick a random host
    $host = $servers[array_rand($servers)];

    // Attempt to connect
    $success = mysqli_real_connect(
        $link,
        $host,
        DB_SUSER,
        DB_SPASSWORD,
        DB_SNAME,
        (int)DB_SPORT
    );

    if ($success === false) {
        // Connection failed: return error message (or handle as needed)
        return mysqli_connect_error();
    }

    // Optionally return raw connection details
    if ($return_con_data === 'get_con_data') {
        return [
            'user' => DB_SUSER,
            'pass' => DB_SPASSWORD,
            'db'   => DB_SNAME,
            'port' => DB_SPORT,
        ];
    }

    return $link;
}

// Establish the sharded connection
$cons = dbs_connect();

// Define project root if not already
if (!defined('__DB_ROOT__')) {
    define('__DB_ROOT__', dirname(dirname(__FILE__)));
}

// Include your DB utilities
require_once(__DB_ROOT__ . "/libnb/php/db_utils.php");
