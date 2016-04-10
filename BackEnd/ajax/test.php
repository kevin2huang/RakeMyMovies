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

 $_POST['userId'] = 10;
 $ran_genre = 7;

 if(isset($_POST['userId']))
    {
      function makeMovieNoTS($ids, $database)
    {  
      $movies = array();
      foreach ($ids as $key=>$value) {
            $movie = array();
            $actors = array();
            $directors = array();
            $studios = array();

           $ret = pg_query($database, "SELECT * 
                                  FROM MOVIES
                                  WHERE MOVIE_ID = " . $ids[$key] . ";");
           
           $ret2 = pg_query($database, "SELECT A.* 
                                  FROM ACTOR A, MOVACT MA, MOVIES M
                                  WHERE M.MOVIE_ID = " . $ids[$key] . " AND 
                                        MA.MOVIE_ID = M.MOVIE_ID AND
                                        MA.ACTOR_ID = A.ACTOR_ID;");

           $ret3 = pg_query($database, "SELECT D.* 
                                  FROM DIRECTOR D, MOVDIR MD, MOVIES M
                                  WHERE M.MOVIE_ID = " . $ids[$key] . " AND 
                                        MD.MOVIE_ID = M.MOVIE_ID AND
                                        MD.DIR_ID = D.DIR_ID;");

           $ret4 = pg_query($database, "SELECT S.* 
                                  FROM STUDIO S, SPONSOR SP, MOVIES M
                                  WHERE M.MOVIE_ID = " . $ids[$key] . " AND 
                                        SP.MOVIE_ID = M.MOVIE_ID AND
                                        SP.STUDIO_ID = S.STUDIO_ID;");

      if(!$ret or !$ret2 or !$ret3 or !$ret4){
        echo pg_last_error($database);
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
      return $movies;
    }

      $ch3_movieids = array();
      //Channel 2: Movies based on a users favorite genre
      $ch3_movies = pg_query($db, "SELECT M.*, G.GENRE_NAME
                            FROM MOVIES M, GENRE G, MOVGEN MG
                            WHERE G.GENRE_ID = " . $ran_genre . " AND 
                            MG.GENRE_ID = G.GENRE_ID AND
                            MG.MOVIE_ID = M.MOVIE_ID
                            LIMIT 6;");

      while($row = pg_fetch_row($ch3_movies)){
        array_push($ch3_movieids, $row[0]);
      }

      $mmovies = makeMovieNoTS($ch3_movieids, $db);
      $allmovies = array('movies' => $mmovies);
      echo json_encode($allmovies);

}
?>