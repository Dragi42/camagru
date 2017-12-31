<?php
include("./Database/db.php");
session_start();
$login = $_SESSION['logged_on_user'];

if ($_POST['submit_image'] == "Upload" && $_POST['myimage'] != NULL) {
	$image_name = $_FILES["myimage"]["name"];

	$data = file_get_contents($_FILES['myimage']['tmp_name']);
	$base64 = 'data:image/png;base64,'.base64_encode($data);
}

else {
	$base64 = $_POST['myimage'];
}

if (($db = connect_db()) && $base64 != '')
{
	$sql = "
		INSERT INTO `Pictures` (`path_img`, `login`) VALUES
			('$base64', '$login');
		";
	$db -> query($sql);
}
	header("location: home.php");
?>
