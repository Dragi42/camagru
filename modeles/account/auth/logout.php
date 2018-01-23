<?php
	unset($_SESSION['login']);
	unset($_SESSION['logged_on_user']);
	unset($_SESSION['id']);
	header('location: ../index.php');
?>
