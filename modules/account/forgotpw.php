<?php

	if ($_SESSION['id'])
		header("location: ./");

	require './view/forgotpw.php';

?>
