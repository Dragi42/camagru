<?php

session_start();
require '../../config/init.php';

$user_id = $_SESSION['id'];
$type = $_FILES['img']['type'];

if ($type == 'image/jpeg' || $type == 'image/png') {
	$image_name = $_FILES["img"]['name'];
	$data = file_get_contents($_FILES['img']['tmp_name']);
	$base64 = 'data:image/png;base64,'.base64_encode($data);
}

//else {
//	$base64 = $_POST['img'];
//}

if (($db = connect_db()) && $base64 != '')
{
	$sql = "INSERT INTO `Pictures` (`path_img`, `user_id`) VALUES ('".$base64."', '".$_SESSION['id']."')";
	$db -> query($sql);
}
	header("location: ../../?module=home&action=index");
?>
