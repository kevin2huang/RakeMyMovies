<?php
	$host        = "host=web0.site.uottawa.ca";
   $port        = "port=15432";
   $dbname      = "dbname=khuan042"; //put your username here
   $credentials = "user=khuan042 password=Huang756!"; //put username + password here

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      pg_query('SET search_path = "RakeMyMovie";');
   }


if(isset($_GET['userId']) and isset($_GET['movieId'])) {
	/*
	Get the rating and the description of the review between that user and that movie. If none
	are found, return the string 'EMPTY'
	*/
} else if (isset($_GET['userId'])) {
	/*
	No movieId was passed, only the userId. Return every review written by this user
	*/
}

if( isset($_POST['userId']) and isset($_POST['movieId']) and 
	isset($_POST['rating']) and isset($_POST['text'])) {

	if( isset($_POST['update']) and $_POST['update']) {
		/*
		If $_POST_['update'] is true, then a review already exists in the database between this user and that moview. Update its rating and description values	
		*/
	} else {
		/*
		Else, then no review previously exists between this user and that movie. Create a new review relation
		*/
	}
	
} 

/*$response = array();
 for ($i = 0; $i < 5; $i++) {
 	$response[] = array(
 		'description': 'This is a review. The description can be more or less long depending on the review. Most of the time, a review will be about one or two paragraphs long.',
 		'rating': 5,
 		'name': 'Anonymous'
 		);*/
}

    echo json_encode($response);
?>
