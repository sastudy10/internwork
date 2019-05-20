<?php
session_start();
 
header("Content-type: text/html; charset=utf-8");
 
if (!isset($_SESSION["account"])) {
	header("Location:log in.php");
	exit();
}
 
$_SESSION = array();
 
if (isset($_COOKIE["PHPSESSID"])) {
	setcookie("PHPSESSID", '', time() - 1800, '/');
}
session_destroy();

header("Location:index.php");
?>
 
