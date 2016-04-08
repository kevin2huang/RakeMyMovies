<?php
$host        = "host=web0.site.uottawa.ca";
   $port        = "port=15432";
   $dbname      = "dbname=khuan042"; //put your username here
   $credentials = "user=khuan042 password=Huang756!"; //put username + password here

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
    $ret = pg_query($db, "INSERT INTO WISH (USER_ID, MOVIE_ID, WISH_TIMESTAMP)
						              VALUES 
                          (" + $user_id + ", " + $movie_id + ", " + $date + ");");

    $ret2 = pg_query($db, "SELECT M.*, W.WISH_TIMESTAMP
                           FROM MOVIES M, RAKEUSER U, WISH W
                           WHERE U.USER_ID = " + $userid + " AND 
                           W.USER_ID = U.USER_ID AND 
                           W.MOVIE_ID = M.MOVIE_ID;");

    $response->status = 'OK';
//} else {
    //$response->status = 'FAILED';
//}
    echo json_encode($response);
?>