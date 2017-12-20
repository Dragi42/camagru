<?php

	function get_img($db, $param) {
		$sql = "SELECT * FROM `Pictures` ".$param.";";
		foreach ($db->query($sql) as $row) {
			echo "
				<img src='".$row['path_img']."' alt='' width='300' height='200'/>
			";
		}
	}

?>
