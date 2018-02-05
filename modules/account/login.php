<?php

	if ($_SESSION['id'])
		redirect();
	require './modeles/account/login.php';

?>
