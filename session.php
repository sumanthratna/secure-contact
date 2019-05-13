<?php
require_once 'config.php';
session_start();

$check = $_SESSION['user'];

$ses_sql = mysqli_query($db, "select username from users where username = '$check' ");

$row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);

$login_session = $row['username'];
if (!isset($_SESSION['user'])) {
    header("location:login.php");
    die();
}
?>