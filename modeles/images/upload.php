<?php

	session_start();
	require '../../config/init.php';

	$folder = "../../images/".$_SESSION['id']."-".$_SESSION['login']."/";
	$errors = [];
		$name = $_POST['image'];
		$explode = explode("/", explode(",", $name)[0]);
		$extension = explode(";", $explode[1])[0];
		$type = explode(":", $explode[0])[1];
		$img = sha1(uniqid($_SESSION['id'], true)).".".$extension;
		$path = $folder.$img;
		$filterpath = parse_url($_POST['filter'])['path'];

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
		else if (!$filterpath) {
			$errors['filter'] = "Please select a filter.";
		}
		else if (!file_exists("../../".$filterpath)) {
			$errors['filter'] = "Please select a Valid filter.";
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
			$filter = imagecreatefrompng("../../".$filterpath);
			$size = getimagesize($path);
			if ($size[0] < 640 || $size[1] < 480) {
				$resize = [640, 480];
				while ($resize[0] > $size[0] || $resize[1] > $size[1]) {
					$ratio = $resize[0]/$resize[1];
					if ($ratio > 1) {
						$resize[0] -= 1;
						$resize[1] = $resize[0]/$ratio;
					}
					else {
						$resize[1] -= 1;
						$resize[0] = $resize[1]*$ratio;
					}
				}
				if ($resize[0] < $size[0]) {
					$middlewidth = ($size[0] - $resize[0]) / 2;
					$middleheight = 0;
				}
				else if ($resize[1] < $size[1]) {
					$middlewidth = 0;
					$middleheight = ($size[1] - $resize[1]) / 2;
				}
				$img = imagecreatetruecolor($resize[0], $resize[1]);
				imagecopyresampled($img,$image,0,0,$middlewidth,$middleheight,$resize[0],$resize[1],$resize[0],$resize[1]);
				$image = $img;
			}
			else if ($size[0] > 640 || $size[1] > 480) {
				$resize = [640, 480];
				while ($resize[0] < $size[0] && $resize[1] < $size[1]) {
					$ratio = $resize[0]/$resize[1];
					$resize[0] += 1;
					$resize[1] = $resize[0]/$ratio;
				}
				if ($resize[0] < $size[0]) {
					$middlewidth = ($size[0] - $resize[0]) / 2;
					$middleheight = 0;
				}
				else if ($resize[1] < $size[1]) {
					$middlewidth = 0;
					$middleheight = ($size[1] - $resize[1]) / 2;
				}
				$img = imagecreatetruecolor($resize[0], $resize[1]);
				imagecopyresampled($img,$image, 0, 0, $middlewidth,$middleheight, $resize[0], $resize[1], $resize[0], $resize[1]);
				$image = $img;
			}

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
	redirect();
?>
