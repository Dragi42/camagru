<?php

	session_start();
	require '../../config/init.php';

	$name = $_FILES["image"]["name"];
	$tmpName = $_FILES["image"]["tmp_name"];
	$type = $_FILES["image"]["type"];
	$size = $_FILES["image"]["size"];
	$errorMsg = $_FILES["image"]["error"];
	$explode = explode(".", $name);
	$extension = end($explode);
	$errors = [];

	//	Starting PHP image upload error handlings

	if (!$tmpName) {
		$errors['file'] = "Please choose file.";
	}
	else if ($size > 5242880) {	//	if file size is larger than 5MB
		$errors['file'] = "Please choose less than 5MB file for uploading.";
		unlink($tmpName);
	}
	else if (!preg_match("/\.(gif|jpg|png|jpeg)$/i",$name)) {
		$errors['file'] = "Please choose the file only with the GIF, PNG or JPG file format.";
		unlink($tmpName);
	}
	else if ($errorMsg == 1) {
		$errors['file'] = "An unexpected error occured while processing the file. Please try again.";
	}

	//	End of PHP image upload error handlings
	
	//	Placing folder "uploads" where files will going to uploaded
	if (!empty($errors)) {
		if (isAjax()) {
			header('Content-Type: application/json', true, 400);
			echo json_encode($errors);
			die();
		}
		$_SESSION['errors'] = $errors;
	}
	else {
		$moveFile = move_uploaded_file($tmpName, "uploads/".$_SESSION['id'].".".$extension);
		if($moveFile != true) {
			$errors['file'] = "File not uploaded. Please try again.";
			unlink($tmpName);
			$_SESSION['errors'] = $errors;
		}
		else {
			$success['success'] = "File successfully uploaded.";
			$_SESSION['success'] = $success;
		}
	}

/*
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
}*/
	redirect();
?>
