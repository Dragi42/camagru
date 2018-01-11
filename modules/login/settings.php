<?php

if (!$_SESSION['logged_on_user'])
	header("location: ./");
require("./modeles/settings/user_settings.php");

require './view/settings.php';

?>
