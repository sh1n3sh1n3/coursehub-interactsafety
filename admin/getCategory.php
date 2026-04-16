<?php session_start(); include('includes/conn.php'); 
$categoryId = $_GET['categoryid'];

$category = $conn->query("SELECT * FROM category WHERE id='".$categoryId."' LIMIT 1")->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($category);