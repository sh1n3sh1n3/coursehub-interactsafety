<?php session_start();
include('include/conn.php');
$_SESSION['pin_user'] = '';
session_destroy();
echo '<script>window.location.href="index.php"</script>';
?>