<?php
//header("Content-Type: application/json");

if (isset($_POST['slide_id'])) {
	
	include_once(__DIR__ . '/db.php');
	$like_db = new database();
	echo json_encode($like_db->test($_POST['slide_id'], $_SERVER['REMOTE_ADDR']));
	if (isset($_POST['event'])) {
		if ($_POST['event']=="like") {
			echo $like_db->person_slider_like ($_POST['slide_id'], $_SERVER['REMOTE_ADDR']);
		} else {
			if ($_POST['event']=="dislike"){
				
				print_r ($like_db->person_slider_dislike ($_POST['slide_id'], $_SERVER['REMOTE_ADDR']));
			}
		}

	} else {
	
	}
 
} else {
	
}


?>