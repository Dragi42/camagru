<?php

	session_start();
	require '../../config/init.php';
	if ($_SESSION['id'])
		redirect();
	require '../../modeles/account/login.php';

?>
