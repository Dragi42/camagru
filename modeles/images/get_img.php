<?php

	function get_all_img() {
		$db = connect_db();
		$images = $db->query('SELECT `path_img`, `like`, `comment` FROM `Pictures` ORDER by `id` desc');
		return ($images);
	}

	function get_user_img() {
		$db = connect_db();
		$images = $db->query("SELECT `path_img`, `like`, `comment` FROM `Pictures` where login='".$_SESSION['login']."' ORDER by `id` desc");
		return ($images);
	}

	function upload_img($db, $param) {
		$db->query("INSERT INTO `Pictures` (`path_img`, `login`) VALUES
				('".$param."', '".$_SESSION['login']."')");
	}
?>
