<?php

	session_start();
	require '../../config/init.php';

	$folder = "../../images/".$_SESSION['id']."-".$_SESSION['login']."/";
	$errors = [];
	else {
		$name = $_POST['image'];
		$explode = explode("/", explode(",", $name)[0]);
		$extension = explode(";", $explode[1])[0];
		$type = explode(":", $explode[0])[1];
		$img = sha1(uniqid($_SESSION['id'], true)).".".$extension;
		$path = $folder.$img;

		function base64_to_jpeg($base64_string, $output_file) {
			$ifp = fopen( $output_file, 'wb' );
			$data = explode( ',', $base64_string );
			fwrite( $ifp, base64_decode( $data[ 1 ] ) );
			fclose( $ifp ); 
			return $output_file;
		}


		if (!$name) {
			$errors['file'] = "Please choose valid file.";
		}
		else if ($type != 'image') {
			$errors['file'] = "Please choose the file only with the PNG or JPG file format.";
		}
		if (!empty($errors)) {
			if (isAjax()) {
				header('Content-Type: application/json', true, 400);
				echo json_encode($errors);
				die();
			}
			$_SESSION['errors'] = $errors;
		}
		else {
			if (!file_exists($folder)) {
				mkdir($folder);
			}

			$moveFile = base64_to_jpeg($name, $path);

			if ($extension == 'png') {
				$image = imagecreatefrompng($path);
			} else {
				$image = imagecreatefromjpeg($path);
			}
			$filter = imagecreatefrompng("../../images/filter/9.png");
				
			$imagewidth = imagesx($image);
			$imageheight = imagesy($image);
			$filterwidth = imagesx($filter);
			$filterheight = imagesy($filter);

			imagecopyresampled($image, $filter, 0, 0, 0, 0, $imagewidth, $imageheight, $filterwidth, $filterheight);
			if ($extension == 'png') {
				imagepng($image, $path);
			} else {
				imagejpeg($image, $path);
			}

			if(!$image) {
				$errors['file'] = "File not uploaded. Please try again.";
				unlink($tmpName);
				$_SESSION['errors'] = $errors;
			}
			else {
				if ($db = connect_db()) {
					$query = $db->prepare("INSERT INTO `Pictures` (`path_img`, `user_id`) VALUES (?, ?)");
					$query->execute([$path, $_SESSION['id']]);
					$success['success'] = "File successfully uploaded.";
					$_SESSION['success'] = $success;
				}
			}
		}
	}
	redirect();
?>
