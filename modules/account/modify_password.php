<?php

	if (!$_SESSION['id'])
		header("location: ./");

	require './modeles/account/modify_password.php';

?>