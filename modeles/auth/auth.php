<?php
	include("auth_function.php");
	session_start();
	if ($_POST['submit'] == "OK") {
		if (($i = auth($_POST['login'], $_POST['password'])) == 1) {
			$_SESSION['logged_on_user'] = NULL;
			$_SESSION['logged_on_user'] = $_POST['login'];
			header("location: ../../index.php");
		}
		else
			header("location: ../../login.php");
	}
	else
		header("location: ../../login.php");
?>
