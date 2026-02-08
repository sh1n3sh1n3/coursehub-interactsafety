<?php 
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com
*/
//Stripe Credentials Configuration
session_start();
include('../include/conn.php');
$priceval = $_SESSION['orderprice'];
$ordertitle = $_SESSION['ordertitle'];
define("STRIPE_SECRET_API_KEY", "sk_test_51RRmNFFpmzbyKL2OdtPBpEk11D3MnfqyIU17ZYzaPJB1ew6t1Q7zbkKdEbZM4BtJRVeDveQy7mR4ZUOrQQ0ddmMq00Vx7m666M");
define("STRIPE_PUBLISHABLE_KEY", "pk_test_51RRmNFFpmzbyKL2Ot3r9TiZ78lSbxbm61lUg9cBo2PhCNILv8LMQLwkha6gmAhWAZ0ENGKxHMFhGFx2ZP2NRHHzB00KKp6bmsH");

//Sample Product Details
define('CURRENCY', 'USD');
define('AMOUNT', $priceval);
define('DESCRIPTION', $ordertitle);

// Database Credentials Configuration 
define('DB_HOST', 'localhost');
define('DB_NAME', 'nrbellezza_pinnacle');
define('DB_USERNAME', 'nrbellezza_pinnacle_user');
define('DB_PASSWORD', 'Company@123#');
?>