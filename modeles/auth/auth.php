<?php
	include("auth_function.php");
	if ($_POST['submit'] == "OK") {
		if (($i = auth($_POST['login'], $_POST['password'])) == 1) {
			$_SESSION['logged_on_user'] = NULL;
			$_SESSION['logged_on_user'] = $_POST['login'];
			header("location: ../../.");
		}
		else
			header("location: ../.././?module=login&action=form");
	}
	else
		header("location: ../.././?module=login&action=form");
?>
