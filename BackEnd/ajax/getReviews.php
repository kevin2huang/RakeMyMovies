<?php
header("content-type:application/json");

	//TODO Connect with database
$response = array();
 for ($i = 0; $i < 5; $i++) {
 	$response[] = array(
 		'description': 'This is a review. The description can be more or less long depending on the review. Most of the time, a review will be about one or two paragraphs long.',
 		'rating': 5,
 		'name': 'Anonymous'
 		);
}

    echo json_encode($response);
?>
