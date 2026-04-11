<?php 
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com
*/
//Stripe Credentials Configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include(__DIR__ . '/../include/conn.php');
$priceval = !empty($_SESSION['orderprice']) ? $_SESSION['orderprice'] : 0;
$ordertitle = !empty($_SESSION['ordertitle']) ? $_SESSION['ordertitle'] : '';
define("STRIPE_SECRET_API_KEY", "");
define("STRIPE_PUBLISHABLE_KEY", "");

//Sample Product Details
define('CURRENCY', 'AUD');
define('AMOUNT', $priceval);
define('DESCRIPTION', $ordertitle);

// Use same database as main app (admin/includes/conn.php)
define('DB_HOST', 'localhost');
define('DB_NAME', 'interac8_coursehub');
define('DB_USERNAME', 'interac8_coursehub');
define('DB_PASSWORD', 'AcZ&xNCzJii,8]g');
?>