<?php
header("content-type:application/json");

	//TODO Connect with database

    $response->status = array('Horror', 'Action', 'Comedy', 'Documentary', 'New', 'Thriller', 'Animated', 'Drama', 'Western');

    $response->artists = array('Robert Downey Jr.', 'Tom Hanks', 'Jonny Depp', 'Tom Cruise', 'Will Smith', 'Brad Pitt', 'Morgan Freeman', 'George Clooney', 'Robin Williams');

    echo json_encode($response);
?>
