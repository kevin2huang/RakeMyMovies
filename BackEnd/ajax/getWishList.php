<?php
   $host        = "host=web0.site.uottawa.ca";
   $port        = "port=15432";
   $dbname      = "dbname=khuan042";
   $credentials = "user=khuan042 password=Huang756!";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      pg_query('SET search_path = "RakeMyMovie";');
   }


header("content-type:application/json");
    //echo json_encode(array( 'movies' => "Yep"));

$response;

if(isset($_POST['userId']) && isset($_POST['movieId'])){
    //Insert the new wish relation between the user and the movie

    $select = pg_query($db, "SELECT M.*, W.WISH_TIMESTAMP
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