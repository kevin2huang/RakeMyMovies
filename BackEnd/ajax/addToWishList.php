<?php
   $host        = "host=web0.site.uottawa.ca";
   $port        = "port=15432";
   $dbname      = "dbname=khuan042";
   $credentials = "user=khuan042 password=Huang756!";

   $db = pg_connect( "$host $port $dbname $credentials"  );

   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
      pg_query('SET search_path = "RakeMyMovie";');
   }


header("content-type:application/json");
    //echo json_encode(array( 'movies' => "Yep"));

$response;

if(isset($_POST['userId']) && isset($_POST['movieId'])){
    //Insert the new wish relation between the user and the movie
    $add = pg_query($db, "INSERT INTO WISH (USER_ID, MOVIE_ID, WISH_TIMESTAMP)
						              VALUES 
                          (" + $user_id + ", " + $movie_id + ", " + $date + ");");

    $response->status = 'OK';
  } 
  else 
  {
      $response->status = 'FAILED';
  }
    echo json_encode($response);
?>