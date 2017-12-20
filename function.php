<?php

	function get_img($db, $param) {
		$sql = "SELECT * FROM `Pictures` ".$param.";";
		foreach ($db->query($sql) as $row) {
			echo "
				<div style='border: 2px solid black; margin: 10px; display: inline-block;'>
					<img src='".$row['path_img']."' alt='' width='300' height='200'/>
					<div style='padding: 10px; display: flex;'>
						<img src='icons/like.ico' alt='likes' width='30' height='30'/>".$row['like']."
						<img src='icons/comment.ico' alt='cemment' width='30' height='30'/>".$row['comment']."
					</div>
				</div>
			";
		}
	}

?>
