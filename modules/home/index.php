<?php

	if (empty($_SESSION))
		header("location: ./");
	require("./modeles/images/get_img.php");

	require './view/home.php';

?>
