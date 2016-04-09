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

if(isset($_POST['userID'])){
  
  $movieids = array();
  $timestamps = array();
  $movies = array();

  if(listType == 'wish')
  {
          $list = pg_query($db, "SELECT M.*, W.WISH_TIMESTAMP
                                 FROM MOVIES M, RAKEUSER U, WISH W
                                 WHERE U.USER_ID = " . $_POST['userID'] . " AND 
                                 W.USER_ID = U.USER_ID AND 
                                 W.MOVIE_ID = M.MOVIE_ID;");
  }
  else if(listType == 'watched')
  {
      $list = pg_query($db, "SELECT M.*, WA.WATCHED_TIMESTAMP
                             FROM MOVIES M, RAKEUSER U, WATCHED WA
                             WHERE U.USER_ID = " . $_POST['userID'] . " AND 
                             WA.USER_ID = U.USER_ID AND 
                             WA.MOVIE_ID = M.MOVIE_ID;");
  }
  else{
    echo "Error";
  }

  while ($row = pg_fetch_row($list)){
     $movieids = array($row[0]);
     $timestamps = array($row[9]);
  }
  
    foreach ($movieids as $movieID) {
          $movie = array();
          $actors = array();
          $directors = array();
          $studios = array();

         $ret = pg_query($db, "SELECT * 
                                FROM MOVIES
                                WHERE MOVIE_ID = " + $movieID + ";");
         
         $ret2 = pg_query($db, "SELECT A.* 
                                FROM ACTOR A, MOVACT MA, MOVIES M
                                WHERE M.MOVIE_ID = " + $movieID + " AND 
                                      MA.MOVIE_ID = M.MOVIE_ID AND
                                      MA.ACTOR_ID = A.ACTOR_ID;");

         $ret3 = pg_query($db, "SELECT D.* 
                                FROM DIRECTOR D, MOVDIR MD, MOVIES M
                                WHERE M.MOVIE_ID = " + $movieID + " AND 
                                      MD.MOVIE_ID = M.MOVIE_ID AND
                                      MD.DIR_ID = D.DIR_ID;");

         $ret4 = pg_query($db, "SELECT S.* 
                                FROM STUDIO S, SPONSOR SP, MOVIES M
                                WHERE M.MOVIE_ID = " + $movieID + " AND 
                                      SP.MOVIE_ID = M.MOVIE_ID AND
                                      SP.STUDIO_ID = S.STUDIO_ID;");

    if(!$ret or !$ret2 or !$ret3 or !$ret4){
      echo pg_last_error($db);
      exit;
    } 

   while($row4 = pg_fetch_row($ret4)){
        $studios = array('studioid' => $row4[0],
                            'studioname' => $row4[1]);
   }     

   while($row3 = pg_fetch_row($ret3)){
        $directors = array('directorid' => $row3[0],
                            'directorname' => $row3[1]);
   } 

   while($row2 = pg_fetch_row($ret2)){
        $actors = array('actorid' => $row2[0],
                        'actorname' => $row2[1]);
   }
    
    while($row = pg_fetch_row($ret))
   {
            $movie = array('movieid' => $row[0], 
                           'movietitle' => $row[1], 
                           'moviecover' => $row[2],
                           'moviereleasedate' => $row[3], 
                           'moviedescription' => $row[4],
                           'movieduration' => $row[5],
                           'movielanguage' => $row[6],
                           'moviecountry' => $row[7],
                           'movietgrating' => $row[8],
                           'actors' => $actors,
                           'directors' => $directors,
                           'studios' => $studios);
    }
    
      array_push($movies, $movie);
    }

    /*
    $response[] = array(
            'movie' => $elem,
            'timestamp' => 'Mon Mar 28 2016'
        );
    */
   // echo json_encode('movies' => $movies);
}
?>