<?php

	if (!$_SESSION['id'])
		header("location: ./");
	require("./modeles/images/get_img.php");
	require("./modeles/images/get_filter.php");

	require './view/home.php';

?>
