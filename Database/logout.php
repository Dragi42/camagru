<?php
	session_start();
	$_SESSION['logged_on_user'] = "";
	$_SESSION['created'] = 0;
	header('location: ../index.php');
?>
