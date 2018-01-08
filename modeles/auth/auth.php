<?php
	include("auth_function.php");
	if ($_POST['submit'] == "OK") {
		if (($i = auth($_POST['login'], $_POST['password'])) == 1) {
			$_SESSION['logged_on_user'] = NULL;
			$_SESSION['logged_on_user'] = $_POST['login'];
			header("location: ../../.");
		}
		else if ($i == 0)
			echo "This account dosen't exist";
		else if ($i == -1)
			echo "Wrong password";
		else if ($i == -2)
			echo 'Complete the form please';
	}
	else
		header("location: ../.././?module=auth&action=form");
?>
