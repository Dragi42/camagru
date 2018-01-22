<?php
	session_start();
	unset($_SESSION['login']);
	unset($_SESSION['logged_on_user']);
	unset($_SESSION['id']);
	$_SESSION['created'] = 0;
	header('location: ../index.php');
?>
