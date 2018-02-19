<?php

	session_start();
	require '../../config/init.php';
	session_unset($_SESSION);
	$_SESSION = [];
	$success['success'] = 'Vous avez été déconnecté avec succes.';
	$_SESSION['success'] = $success;
	redirect();

?>
