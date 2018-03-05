<?php

	if (empty($_SESSION))
		header("location: ./");
	require("./modeles/images/get_img.php");
	require("./modeles/images/get_filter.php");

	require './view/home.php';

?>
