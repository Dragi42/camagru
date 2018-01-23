<?php

if (empty($_SESSION))
	header("location: ./");
require("./modeles/images/get_img.php");

$images = get_user_img();

require './view/home.php';

?>
