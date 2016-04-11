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

    $_POST['userId'] = 10;

    $ran_actor = rand(1, 100);
    do {   
        $ran_genre = rand(1, 22);
    }while(in_array($ran_genre, array(11)));

    do {   
        $ran_genre2 = rand(1, 22);
    }while(in_array($ran_genre2, array(11)));

    $ran_director = rand(1, 31);
    $channels = array();

    //movie id arrays for each channel
    $m_id_ch1 = array();
    //$m_id_ch2 = array();
    $m_id_ch3 = array();
    $m_id_ch4 = array();
    $m_id_ch5 = array();
    $m_id_ch6 = array();

    
    $ch3_genreids = array();
    $ch4_actorids = array();
    $ch5_genreids = array();
    $ch6_directorids = array();

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
                                     'actors' => $actors,
                                     'directors' => $directors,
                                     'studios' => $studios);
              }
             array_push($movies, $movie);
            }
            return $movies;
    } 

    function getGenreName($genreid, $database)
    {
       $genre_name_query = pg_query($database, "SELECT GENRE_NAME 
                                                FROM GENRE
                                                WHERE GENRE_ID = " . $genreid . ";");

       while($row = pg_fetch_row($genre_name_query)){
          $genre_name = $row[0];
        }
       return $genre_name;
    }

    function getDirectorName($directorid, $database)
    {
      $dir_name_query = pg_query($database, "SELECT DIR_NAME 
                                                FROM DIRECTOR
                                                WHERE DIR_ID = " . $directorid . ";");

       while($row = pg_fetch_row($dir_name_query)){
          $dir_name = $row[0];
        }
       return $dir_name;
    }

    function getActorName($actorid, $database)
    {
      $actor_name_query = pg_query($database, "SELECT ACTOR_NAME 
                                                FROM ACTOR
                                                WHERE ACTOR_ID = " . $actorid . ";");

       while($row = pg_fetch_row($actor_name_query)){
          $actor_name = $row[0];
        }
       return $actor_name;
    }

    function selectRandomIndex($arrayids){
      return $arrayids[array_rand($arrayids)];
    }

    if(isset($_POST['userId']))
    {
      //Channel 3: Movies based on a users favorite genre
      $ch3_genreids_query = pg_query($db, "SELECT G.GENRE_ID 
                          FROM GENRE G, RAKEUSER U, USRGEN UG
                          WHERE U.USER_ID = " . $_POST['userId'] . " AND 
                          UG.USER_ID = U.USER_ID AND 
                          UG.GENRE_ID = G.GENRE_ID;");

      while($row = pg_fetch_row($ch3_genreids_query)){
        array_push($ch3_genreids, $row[0]);
      }

      $genreid = selectRandomIndex($ch3_genreids);
      
      $ch3_movieids_query = pg_query($db, "SELECT M.MOVIE_ID
                                            FROM MOVIES M, MOVGEN MG, GENRE G
                                            WHERE G.GENRE_ID =" . $genreid . "AND
                                            MG.GENRE_ID = G.GENRE_ID AND
                                            MG.MOVIE_ID = M.MOVIE_ID;");

      while($row = pg_fetch_row($ch3_movieids_query)){
        array_push($m_id_ch3, $row[0]);
      }    

      //Channel 4: Movies based on users favorite actors
      $ch4_actorids_query = pg_query($db, "SELECT A.ACTOR_ID 
                          FROM ACTOR A, RAKEUSER U, USRACT UA
                          WHERE U.USER_ID = " . $_POST['userId'] . " AND 
                          UA.USER_ID = U.USER_ID AND 
                          UA.ACTOR_ID = A.ACTOR_ID;");

      while($row = pg_fetch_row($ch4_actorids_query)){
        array_push($ch4_actorids, $row[0]);
      }

      $actorid = selectRandomIndex($ch4_actorids);

      $ch4_movieids_query = pg_query($db, "SELECT M.MOVIE_ID
                                            FROM MOVIES M, MOVACT MA, ACTOR A
                                            WHERE A.ACTOR_ID =" . $actorid . "AND
                                            MA.ACTOR_ID = A.ACTOR_ID AND
                                            MA.MOVIE_ID = M.MOVIE_ID;");

      while($row = pg_fetch_row($ch4_movieids_query)){
        array_push($m_id_ch4, $row[0]);
      }

      if(!$ch4_movieids_query or !$ch3_movieids_query){
          echo pg_last_error($db);
          exit;
      }    
    } 
    else 
    {
      //Channel 2: Movies based on a randomly selected genre
      $ch3_movies_query = pg_query($db, "SELECT M.*, G.GENRE_ID
                            FROM MOVIES M, GENRE G, MOVGEN MG
                            WHERE G.GENRE_ID = " . $ran_genre . " AND 
                            MG.GENRE_ID = G.GENRE_ID AND
                            MG.MOVIE_ID = M.MOVIE_ID
                            LIMIT 6;");

      while($row = pg_fetch_row($ch3_movies_query)){
        array_push($m_id_ch3, $row[0]);
        $ch3_genreids = array($row[9]);
      }

      //Channel 3: Movies based on randomly selected actor
      $ch4_movies_query = pg_query($db, "SELECT M.*, A.ACTOR_ID
                          FROM MOVIES M, ACTOR A, MOVACT MA
                          WHERE A.ACTOR_ID = " . $ran_actor . " AND 
                          MA.ACTOR_ID = A.ACTOR_ID AND
                          MA.MOVIE_ID = M.MOVIE_ID
                          LIMIT 6;");

        while($row = pg_fetch_row($ch4_movies_query)){
        array_push($m_id_ch4, $row[0]);
        $ch4_actorids = array($row[9]);
      }

      if(!$ch3_movies_query or !$ch4_movies_query){
        echo pg_last_error($db);
        exit;
      }
    }

    //Channel 1: Top rated 6 movies
    $ch1_movies_query = pg_query($db, "SELECT M.MOVIE_ID, AVG(R.REVIEW_RATING)
                          FROM REVIEW R, MOVREV MR, MOVIES M
                          WHERE R.REVIEW_ID = MR.REVIEW_ID AND
                          MR.MOVIE_ID = M.MOVIE_ID
                          GROUP BY M.MOVIE_ID
                          ORDER BY AVG(R.REVIEW_RATING) DESC
                          LIMIT 6;");

    while($row = pg_fetch_row($ch1_movies_query)){
        array_push($m_id_ch1, $row[0]);
    }

    //Channel 2: Movies with the most reviews
    //$ch2 = pg_query($db, "");

    //Channe5 : Movies with a genre x
    $ch5_movies_query = pg_query($db, "SELECT M.*, G.GENRE_ID
                            FROM MOVIES M, GENRE G, MOVGEN MG
                            WHERE G.GENRE_ID = " . $ran_genre2 . " AND 
                            MG.GENRE_ID = G.GENRE_ID AND
                            MG.MOVIE_ID = M.MOVIE_ID
                            LIMIT 6;");

      while($row = pg_fetch_row($ch5_movies_query)){
        array_push($m_id_ch5, $row[0]);
        $ch5_genreids = array($row[9]);
      }

    //Channel 6: Movies with a director x
    $ch6_movies_query = pg_query($db, "SELECT M.*, D.DIR_ID
                          FROM MOVIES M, DIRECTOR D, MOVDIR MD
                          WHERE D.DIR_ID = " . $ran_director . " AND 
                          MD.DIR_ID = D.DIR_ID AND
                          MD.MOVIE_ID = M.MOVIE_ID
                          LIMIT 6;");

    while ($row = pg_fetch_row($ch6_movies_query))
    {
       array_push($m_id_ch6, $row[0]);
       $ch6_directorids = array($row[9]);
    }

    //create list of movies
    $ch1_movies = makeMovie($m_id_ch1, $db); 
    //$ch2_movies = makeMovie($m_id_ch2, $db); 
    $ch3_movies = makeMovie($m_id_ch3, $db); 
    $ch4_movies = makeMovie($m_id_ch4, $db); 
    $ch5_movies = makeMovie($m_id_ch5, $db); 
    $ch6_movies = makeMovie($m_id_ch6, $db); 

    //create name for each channels
    $ch1_name = "Top Rated Movies";
    //$ch2_name = "Most discussed movies";
    $ch3_name = getGenreName($genreid, $db);
    $ch4_name = "Movies with " . getActorName($actorid, $db);
    $ch5_name = getGenreName($ch5_genreids[0], $db);
    $ch6_name = getDirectorName($ch6_directorids[0], $db);
    
    if(!$ch1_movies_query or !$ch5_movies_query or !$ch6_movies_query){
      echo pg_last_error($db);
      exit;
    }
    else{

    $ch1 = array('name' => $ch1_name, 'movies' => $ch1_movies);

    $ch3 = array('name' => $ch3_name, 'movies' => $ch3_movies);
    $ch4 = array('name' => $ch4_name, 'movies' => $ch4_movies);
    $ch5 = array('name' => $ch5_name, 'movies' => $ch5_movies);
    $ch6 = array('name' => $ch6_name, 'movies' => $ch6_movies);

    $channels = array($ch1, $ch3, $ch4, $ch5, $ch6);

    $response = array('channels' => $channels);
    echo json_encode($response);
    pg_close($db); 
  }

/*
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
*/
?>