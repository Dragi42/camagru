<?php

	if (!$_SESSION['id'])
		header("location: ./");

	require './view/settings.php';
	unset($_SESSION['inputs']);

?>
