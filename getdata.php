<?php
include("./Database/db.php");
session_start();
$login = $_SESSION['logged_on_user'];

$image_name = $_FILES["myimage"]["name"];

$data = file_get_contents($_FILES['myimage']['tmp_name']);
$base64 = 'data:image/png;base64,'.base64_encode($data);

if ($db = connect_db())
{
	$sql = "
		INSERT INTO `Pictures` (`path_img`, `login`) VALUES
			('$base64', '$login');
		";
	$db -> query($sql);
}
	header("location: home.php");
?>
