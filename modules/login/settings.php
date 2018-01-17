<?php

	if (!$_SESSION['logged_on_user'])
		header("location: ./");
	require("./modeles/settings/user_settings.php");

	$profil = user_params();

	require './view/settings.php';

?>
