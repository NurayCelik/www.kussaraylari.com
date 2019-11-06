<?php 
ob_start();
session_start();

if (!isset($_SESSION['name'])) {
	
	header("Location:urunler/login.php");

} else {

	header("Location:urunler/");

}

?>