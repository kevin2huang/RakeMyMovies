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

    if(isset($_POST['userId'])){
        //Do something if the user is set

    } 
    else 
    {
        //Do another search if the user is not set. Select different channels, top rated and so on
    }

    $channels = array();
        
    //TODO Replace the following with a database check
  
    $ran_actor = rand(1, 100);
    $ran_genre = rand(1, 22);

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

    //Channel 2: Movies based on a users favorite genre
    $ch2 = pg_query($db, "SELECT M.*
                          FROM MOVIES M, RAKEUSER U, GENRE G, USRGEN UG, MOVGEN MG
                          WHERE U.USER_ID = " + $userid + " AND 
                          UG.USER_ID = U.USER_ID AND 
                          UG.GENRE_ID = G.GENRE_ID AND 
                          MG.MOVIE_ID = M.MOVIE_ID
                          LIMIT 6;");

    //Channel 3: Movies based on users favorite actors
    $ch3 = pg_query($db, "SELECT M.*
                          FROM MOVIES M, RAKEUSER U, ACTOR A, USRACT UA, MOVACT MA
                          WHERE U.USER_ID = " + $userid + " AND 
                          UA.USER_ID = U.USER_ID AND 
                          UA.ACTOR_ID = A.ACTOR_ID AND 
                          MA.MOVIE_ID = M.MOVIE_ID
                          LIMIT 6;");    

    //Channel 4: Movies with the most reviews
    $ch4 = pg_query($db, "");

    //Channel 5: Movies with a actor x
    $ch5 = pg_query($db, "SELECT M.*
                          FROM MOVIES M, ACTOR A, MOVACT MA
                          WHERE A.ACTOR_ID = " + $ran_actor + " AND 
                          MA.ACTOR_ID = A.ACTOR_ID AND
                          MA.MOVIE_ID = M.MOVIE_ID
                          LIMIT 6;");

    //Channel 6: Movies with a genre x
    $ch6 = pg_query($db, "SELECT M.*
                          FROM MOVIES M, GENRE G, MOVGEN MG
                          WHERE G.GENRE_ID = " + $ran_genre + " AND 
                          MG.GENRE_ID = G.GENRE_ID AND
                          MG.MOVIE_ID = M.MOVIE_ID
                          LIMIT 6;");


    $ch1_movies = array();
    $ch2_movies = array();
    $ch3_movies = array();
    $ch4_movies = array();
    $ch5_movies = array();
    $ch6_movies = array();

    if(!$ch1 or !$ch2 or !$ch3 or !$ch4 or !$ch5 or !$ch6){
      echo pg_last_error($db);
      exit;
    } 

     while($row = pg_fetch_row($ch1))
   {
            $ch1 = array('movieid' => $row[0], 
                           'movietitle' => $row[1], 
                           'moviecover' => $row[2],
                           'moviereleasedate' => $row[3], 
                           'moviedescription' => $row[4],
                           'movieduration' => $row[5],
                           'movielanguage' => $row[6],
                           'moviecountry' => $row[7],
                           'movietgrating' => $row[8]);
    }

    while($row = pg_fetch_row($ch2))
   {
            $ch2_movies = array('movieid' => $row[0], 
                           'movietitle' => $row[1], 
                           'moviecover' => $row[2],
                           'moviereleasedate' => $row[3], 
                           'moviedescription' => $row[4],
                           'movieduration' => $row[5],
                           'movielanguage' => $row[6],
                           'moviecountry' => $row[7],
                           'movietgrating' => $row[8]);
    }

    while($row = pg_fetch_row($ch3))
   {
            $ch3_movies = array('movieid' => $row[0], 
                           'movietitle' => $row[1], 
                           'moviecover' => $row[2],
                           'moviereleasedate' => $row[3], 
                           'moviedescription' => $row[4],
                           'movieduration' => $row[5],
                           'movielanguage' => $row[6],
                           'moviecountry' => $row[7],
                           'movietgrating' => $row[8]);
    }

    while($row = pg_fetch_row($ch4))
   {
            $ch4_movies = array('movieid' => $row[0], 
                           'movietitle' => $row[1], 
                           'moviecover' => $row[2],
                           'moviereleasedate' => $row[3], 
                           'moviedescription' => $row[4],
                           'movieduration' => $row[5],
                           'movielanguage' => $row[6],
                           'moviecountry' => $row[7],
                           'movietgrating' => $row[8]);
    }

    while($row = pg_fetch_row($ch5))
   {
            $ch5_movies = array('movieid' => $row[0], 
                           'movietitle' => $row[1], 
                           'moviecover' => $row[2],
                           'moviereleasedate' => $row[3], 
                           'moviedescription' => $row[4],
                           'movieduration' => $row[5],
                           'movielanguage' => $row[6],
                           'moviecountry' => $row[7],
                           'movietgrating' => $row[8]);
    }

    while($row = pg_fetch_row($ch6))
   {
            $ch6_movies = array('movieid' => $row[0], 
                           'movietitle' => $row[1], 
                           'moviecover' => $row[2],
                           'moviereleasedate' => $row[3], 
                           'moviedescription' => $row[4],
                           'movieduration' => $row[5],
                           'movielanguage' => $row[6],
                           'moviecountry' => $row[7],
                           'movietgrating' => $row[8]);
    }
/*
    for ($i = 0; $i < 5; $i++) {
        $channel = array();

        for ($j = 0; $j < 6; $j++) {

            $elem = array(
                'name' => 'This is a movie',
                'time' => '1h30',
                'rating' => 5,
                'description' => 'This is a random description of a movie. Most movies contain a certain number of actors, named the cast, along with usually one or more directors and one or more studio. A good movie gets a good rating, whereas a bad movie gets a bad rating.',
                'year' => '1996',
                'studio' => 'Walt Disney',
                'director' => array('Martin Luther King'),
                'cast' => array('Angelina Jolie', 'Brad Pit', 'Will smith', 'Leonardo DiCaprio')
           );

            $channel[] = $elem;
        }
    }
    */
    $channels = array('channel1' => $ch1_movies, 
                      'channel2' => $ch2_movies,
                      'channel3' => $ch3_movies,
                      'channel4' => $ch4_movies,
                      'channel5' => $ch5_movies,
                      'channel6' => $ch6_movies);

    $response = array('channels' => $channels);

    echo json_encode($response);
?>