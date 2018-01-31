<?php
session_start();
include("../../config/init.php");

$login = $_SESSION['login'];
$type = $_FILES['myimage']['type'];

if ($type == 'image/jpeg' || $type == 'image/png') {
	$image_name = $_FILES["myimage"]['name'];
	$data = file_get_contents($_FILES['myimage']['tmp_name']);
	$base64 = 'data:image/png;base64,'.base64_encode($data);
}

//else {
//	$base64 = $_POST['myimage'];
///}

if (($db = connect_db()) && $base64 != '')
{
	$sql = "
		INSERT INTO `Pictures` (`path_img`, `login`) VALUES
			('$base64', '$login');
		";
	$db -> query($sql);
}
	header("location: ../../?module=home&action=index");
?>
