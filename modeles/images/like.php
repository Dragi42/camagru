<?php

	if ($db = connect_db()) {
		$query = $db->prepare("SELECT `user_id` FROM `Likes` WHERE `picture_id` = ?");
		$query->execute([$_POST['picture_id']]);
		$exist = $query->fetchAll();
		for ($i = 0; $i < count($exist); $i++) {
			if ($exist[$i][0] === $_SESSION['id']) {
				var_dump('Tu as déjà liker cette photo.');
				$req = "DELETE FROM `Likes` WHERE picture_id=".$_POST['picture_id'].", user_id=".$_SESSION['id'].")";
				$db->query($req);
				die();
			}
		}
		var_dump('Like');
		$req = "INSERT INTO `Likes` (`picture_id`,`user_id`) VALUES ('".$_POST['picture_id']."', '".$_SESSION['id']."')";
		$db->query($req);
	}
?>
