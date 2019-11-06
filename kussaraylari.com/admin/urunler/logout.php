<?php 
session_start();
session_destroy();
unset($_SESSION['name']);
header('Location:login.php?durum=exit',TRUE,302);

?>
