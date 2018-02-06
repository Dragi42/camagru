<?php

	session_unset($_SESSION);
	$_SESSION = [];
	$success['success'] = 'Vous etes déconnecté.';
	$_SESSION['success'] = $success;
	header('location: /?module=account&action=index');

?>
