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
define("STRIPE_SECRET_API_KEY", "sk_test_51RRmNFFpmzbyKL2OdtPBpEk11D3MnfqyIU17ZYzaPJB1ew6t1Q7zbkKdEbZM4BtJRVeDveQy7mR4ZUOrQQ0ddmMq00Vx7m666M");
define("STRIPE_PUBLISHABLE_KEY", "pk_test_51RRmNFFpmzbyKL2Ot3r9TiZ78lSbxbm61lUg9cBo2PhCNILv8LMQLwkha6gmAhWAZ0ENGKxHMFhGFx2ZP2NRHHzB00KKp6bmsH");

//Sample Product Details
define('CURRENCY', 'USD');
define('AMOUNT', $priceval);
define('DESCRIPTION', $ordertitle);

// Use same database as main app (admin/includes/conn.php)
define('DB_HOST', 'localhost');
define('DB_NAME', 'interac8_coursehub');
define('DB_USERNAME', 'interac8_coursehub');
define('DB_PASSWORD', 'AcZ&xNCzJii,8]g');
?>