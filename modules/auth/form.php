<?php

if ($_SESSION['logged_on_user'])
	header("location: ./");

if ($_SESSION['created'] == 1) {
	echo "<html><h2 style='color: green; text-align: center;'>Account created Succefully !</h2><hr></html>";
	$_SESSION['created'] = 0;
}

if ($_SESSION['created'] == -1) {
	echo "<html><h2 style='color: red; text-align: center;'>Confirm Password or Password doesn't match</h2><hr></html>";
	$_SESSION['created'] = 0;
}

if ($_SESSION['created'] == -2) {
	echo "<html><h2 style='color: red; text-align: center;'>Account already used</h2><hr></html>";
	$_SESSION['created'] = 0;
}

if ($_SESSION['created'] == -3) {
	echo "<html><h2 style='color: red; text-align: center;'>Please complete the form</h2><hr></html>";
	$_SESSION['created'] = 0;
}

require './view/login.php';

?>
