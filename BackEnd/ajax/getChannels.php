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

    $ran_actor = rand(1, 100);
    $ran_genre = rand(1, 22);
    $channels = array();

    //movie id arrays for each channel
    $m_id_ch1 = array();
    $m_id_ch2 = array();
    $m_id_ch3 = array();
    $m_id_ch4 = array();
    $m_id_ch5 = array();
    $m_id_ch6 = array();

    function makeMovie($ids, $database)   
    {  
            $movies = array();
            foreach ($ids as $key=>$value) 
            {
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

    if(isset($_POST['userId']))
    {
      //Channel 2: Movies based on a users favorite genre
      $ch2 = pg_query($db, "SELECT M.*
                          FROM MOVIES M, RAKEUSER U, USRGEN UG, MOVGEN MG
                          WHERE U.USER_ID = " . $userid . " AND 
                          UG.USER_ID = U.USER_ID AND 
                          UG.GENRE_ID = MG.GENRE_ID AND 
                          MG.MOVIE_ID = M.MOVIE_ID
                          LIMIT 6;");

      //Channel 3: Movies based on users favorite actors
      $ch3 = pg_query($db, "SELECT M.*
                          FROM MOVIES M, RAKEUSER U, USRACT UA, MOVACT MA
                          WHERE U.USER_ID = " . $userid . " AND 
                          UA.USER_ID = U.USER_ID AND 
                          UA.ACTOR_ID = MA.ACTOR_ID AND
                          MA.MOVIE_ID = M.MOVIE_ID
                          LIMIT 6;");
    } 
    else 
    {
      //Channel 2: Movies based on a randomly selected genre
      $ch2 = pg_query($db, "SELECT M.*
                            FROM MOVIES M, GENRE G, MOVGEN MG
                            WHERE G.GENRE_ID = " . $ran_genre . " AND 
                            MG.GENRE_ID = G.GENRE_ID AND
                            MG.MOVIE_ID = M.MOVIE_ID
                            LIMIT 6;");

      //Channel 3: Movies based on randomly selected actor
      $ch3 = pg_query($db, "SELECT M.*
                          FROM MOVIES M, ACTOR A, MOVACT MA
                          WHERE A.ACTOR_ID = " . $ran_actor . " AND 
                          MA.ACTOR_ID = A.ACTOR_ID AND
                          MA.MOVIE_ID = M.MOVIE_ID
                          LIMIT 6;");
    }

    while ($row = pg_fetch_row($ch2))
    {
       array_push($m_id_ch2, $row[0]);
    }
    while ($row = pg_fetch_row($ch3))
    {
       array_push($m_id_ch3, $row[0]);
    }

    //Channel 1: Top rated 6 movies
    $ch1 = pg_query($db, "SELECT M.MOVIE_ID, AVG(R.REVIEW_RATING) AS Review_Average 
                          FROM REVIEW R, MOVREV MR, MOVIES M
                          WHERE R.REVIEW_ID = MR.REVIEW_ID AND 
                          MR.MOVIE_ID = MR.REVIEW_ID
                          ORDER BY 2;");

    $ch1_1 = pg_query($db, "SELECT *
                            FROM MOVIES
                            WHERE MOVIE_ID = "+ $movieid + "
                            LIMIT 6;");

    //Channel 4: Movies with the most reviews
    $ch4 = pg_query($db, "");

    //Channel 5: Movies with a actor x
    $ch5 = pg_query($db, "SELECT M.*
                          FROM MOVIES M, ACTOR A, MOVACT MA
                          WHERE A.ACTOR_ID = " . $ran_actor . " AND 
                          MA.ACTOR_ID = A.ACTOR_ID AND
                          MA.MOVIE_ID = M.MOVIE_ID
                          LIMIT 6;");

    //Channel 6: Movies with a genre x
    $ch6 = pg_query($db, "SELECT M.*
                          FROM MOVIES M, GENRE G, MOVGEN MG
                          WHERE G.GENRE_ID = " . $ran_genre . " AND 
                          MG.GENRE_ID = G.GENRE_ID AND
                          MG.MOVIE_ID = M.MOVIE_ID
                          LIMIT 6;");

    while ($row = pg_fetch_row($ch5))
    {
       array_push($m_id_ch5, $row[0]);
    }

    while ($row = pg_fetch_row($ch6))
    {
       array_push($m_id_ch6, $row[0]);
    }

    $ch1_movies = makeMovie($m_id_ch1, $db); 
    $ch2_movies = makeMovie($m_id_ch2, $db); 
    $ch3_movies = makeMovie($m_id_ch3, $db); 
    $ch4_movies = makeMovie($m_id_ch4, $db); 
    $ch5_movies = makeMovie($m_id_ch5, $db); 
    $ch6_movies = makeMovie($m_id_ch6, $db); 

    if(!$ch1 or !$ch2 or !$ch3 or !$ch4 or !$ch5 or !$ch6){
      echo pg_last_error($db);
      exit;
    } 

    $channels = array('channel1' => $ch1_movies, 
                      'channel2' => $ch2_movies,
                      'channel3' => $ch3_movies,
                      'channel4' => $ch4_movies,
                      'channel5' => $ch5_movies,
                      'channel6' => $ch6_movies);

    $response = array('channels' => $channels);
    $response 
    echo json_encode($response);
?>

{
  channels: [
    {
      name: "Top rated movies"
      movies: [...]
    },
    {
      name: "Top rated movies"
      movies: [...]
    },
  ]
}