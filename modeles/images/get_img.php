<?php

	function get_all_img() {
		$db = connect_db();
		$images = $db->query('SELECT `path_img`, `like`, `comment` FROM `Pictures` ORDER by `id` desc');
		return ($images);
	}

	function get_user_img() {
		$db = connect_db();
		$images = $db->query("SELECT `id`, `path_img`, `like`, `comment` FROM `Pictures` where user_id='".$_SESSION['id']."' ORDER by `id` desc");
		return ($images);
	}

?>
