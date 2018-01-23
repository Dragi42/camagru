<?php

	if ($_SESSION['id'])
		header("location: ./");

	require './modeles/account/create.php';

?>
