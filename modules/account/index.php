<?php

	if ($_SESSION['id'])
		header("location: ./");

	require './view/log.php';

	unset($_SESSION['inputs']);
	unset($_SESSION['success']);
	unset($_SESSION['logged']);
	unset($_SESSION['errors']);

?>
