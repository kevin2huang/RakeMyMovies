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
function getMovieRating($movieid, $database){
      $getmovierat = pg_query($database, "SELECT AVG(R.REVIEW_RATING)
                                           FROM REVIEW R, MOVIES M, MOVREV MR 
                                           WHERE M.MOVIE_ID = ". $movieid ." AND 
                                           M.MOVIE_ID = MR.MOVIE_ID AND 
                                           MR.REVIEW_ID = R.REVIEW_ID
                                           GROUP BY R.REVIEW_RATING
                                           ORDER BY AVG(R.REVIEW_RATING);");
      $rating = pg_fetch_row($getmovierat);
      return round($rating[0]);
    }

function makeMovieNoTS($ids, $database)
  {  
    $movies = array();
    foreach ($ids as $key=>$value) {
          $movie = array();
          $actors = array();
          $directors = array();
          $studios = array();
          $avgrating = getMovieRating($ids[$key], $database); 

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
          array_push($studios, array('studioid' => $row4[0],
                              'studioname' => $row4[1]));
     }     

     while($row3 = pg_fetch_row($ret3)){
          array_push($directors, array('directorid' => $row3[0],
                              'directorname' => $row3[1]));
     } 

     while($row2 = pg_fetch_row($ret2)){
          array_push($actors, array('actorid' => $row2[0],
                          'actorname' => $row2[1]));
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
                             'trailerUrl' => $row[9],
                             'actors' => $actors,
                             'directors' => $directors,
                             'studios' => $studios,
                             'rating' => $avgrating);
      }
       array_push($movies, $movie);
    }
      return $movies;
}
function makeMovieWithTS($ids, $database, $ts)
  {  
    $movies = array();
    foreach ($ids as $key=>$value) {
          $movie = array();
          $actors = array();
          $directors = array();
          $studios = array();
          $avgrating = getMovieRating($ids[$key], $database); 

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
          array_push($studios, array('studioid' => $row4[0],
                              'studioname' => $row4[1]));
     }     

     while($row3 = pg_fetch_row($ret3)){
          array_push($directors, array('directorid' => $row3[0],
                              'directorname' => $row3[1]));
     } 

     while($row2 = pg_fetch_row($ret2)){
          array_push($actors, array('actorid' => $row2[0],
                          'actorname' => $row2[1]));
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
                           'trailerUrl' => $row[9],
                           'actors' => $actors,
                           'directors' => $directors,
                           'studios' => $studios,
                           'rating' => $avgrating,
                           'timestamp' => $ts[$key]);
    }
     array_push($movies, $movie);
    }
    return $movies;
  }

$movieids = array();

if(isset($_POST['userId']))
{  
  $timestamps = array();

  if ($_POST['listType'] === 'wish') 
  {
    $list = pg_query($db, "SELECT M.*, W.WISH_TIMESTAMP
                            FROM MOVIES M, RAKEUSER U, WISH W
                            WHERE U.USER_ID = " . $_POST['userId'] . " AND 
                            W.USER_ID = U.USER_ID AND 
                            W.MOVIE_ID = M.MOVIE_ID;");

    while ($row = pg_fetch_row($list))
    {
       array_push($movieids, $row[0]);
       array_push($timestamps, $row[9]);
    }

    $mmovies = makeMovieWithTS($movieids, $db, $timestamps);
  }

  else if($_POST['listType'] === 'watched')
  {
    $list = pg_query($db, "SELECT M.*, W.WATCHED_TIMESTAMP
                            FROM MOVIES M, RAKEUSER U, WATCHED W
                            WHERE U.USER_ID = " . $_POST['userId'] . " AND 
                            W.USER_ID = U.USER_ID AND 
                            W.MOVIE_ID = M.MOVIE_ID;");

    while ($row = pg_fetch_row($list))
    {
       array_push($movieids, $row[0]);
       array_push($timestamps, $row[9]);
    }
    $mmovies = makeMovieWithTS($movieids, $db, $timestamps);
  }
}
  else if (isset($_POST['movieId']))
{
  $list = pg_query($db, "SELECT *
                          FROM MOVIES 
                          WHERE MOVIE_ID = " . $_POST['movieId'] . ";");

  while ($row = pg_fetch_row($list))
  {
     array_push($movieids, $row[0]);
  }
  $mmovies = makeMovieNoTS($movieids, $db);
}
else if (isset($_POST['genreId']))
{
  $list = pg_query($db, "SELECT M.*
                          FROM MOVIES M, GENRE G, MOVGEN MG
                          WHERE G.GENRE_ID = " . $_POST['genreId'] . "AND
                          G.GENRE_ID = MG.GENRE_ID AND 
                          MG.MOVIE_ID = M.MOVIE_ID;");

  while ($row = pg_fetch_row($list))
  {
     array_push($movieids, $row[0]);
  }
  $mmovies = makeMovieNoTS($movieids, $db);
}
else if (isset($_POST['directorId']))
{
  $list = pg_query($db, "SELECT M.*
                          FROM MOVIES M, DIRECTOR D, MOVDIR MD
                          WHERE D.DIR_ID = " . $_POST['directorId'] . "AND
                          D.DIR_ID = MD.DIR_ID AND
                          MD.MOVIE_ID = M.MOVIE_ID;");

  while ($row = pg_fetch_row($list))
  {
     array_push($movieids, $row[0]);
  }
  $mmovies = makeMovieNoTS($movieids, $db);
}
  else
  {
    echo "ERROR";
  }

   $allmovies = array('movies' => $mmovies);
   echo json_encode($allmovies);
   pg_close($db);
?>