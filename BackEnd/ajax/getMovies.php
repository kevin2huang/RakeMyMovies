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
      pg_query('SET search_path = "RakeMyMovies";');
   }

//array of movie IDs
header("content-type:application/json");

$movies = array();

if(isset($_POST['movieIDs'])){

    $movie = array();
    $actors = array();
    $directors = array();

    foreach ($_POST['movieIDs'] as $movieID) {
         $ret = pg_query($db, "SELECT M.*, A.*, D.*, S.*
                                 FROM MOVIES M, ACTOR A, MOVACT MA, DIRECTOR D, MOVDIR MD, STUDIO S, SPONSOR SP
                                 WHERE M.MOVIE_ID = " + $movieID + " AND
                                        A.ACTOR_ID = MA.ACTOR_ID AND
                                        MA.MOVIE_ID = M.MOVIE_ID AND
                                        D.DIRECTOR_ID = MD.DIRECTOR_ID AND 
                                        MD.MOVIE_ID = MOVIE_ID AND 
                                        SP.MOVIE_ID = M.MOVIE_ID AND 
                                        SP.STUDIO_ID = S.STUDIO_ID;")
         /*
         $ret2 = pg_query($db, "SELECT * 
                                FROM ACTOR A
                                WHERE A.ACTOR_ID = (SELECT MA.ACTOR_ID 
                                FROM MOVACT MA, MOVIES M
                                WHERE M.MOVIE_ID = " + $movieid +" AND MA.MOVIE_ID = M.MOVIE_ID);");

         $ret3 = pg_query($db, "SELECT * 
                                FROM DIRECTOR D
                                WHERE D.DIRECTOR_ID = (SELECT MD.DIRECTOR_ID 
                                FROM MOVDIR MD, MOVIES M
                                WHERE M.MOVIE_ID = " + $movieid + " AND MD.MOVIE_ID = M.MOVIE_ID);");

         $ret4 = pg_query($db, "SELECT * 
                                FROM DIRECTOR D
                                WHERE D.DIRECTOR_ID = (SELECT MD.DIRECTOR_ID 
                                FROM MOVDIR MD, MOVIES M
                                WHERE M.MOVIE_ID = " + $movieid + " AND MD.MOVIE_ID = M.MOVIE_ID);");
*/
    if(!$ret or !$ret2){
      echo pg_last_error($db);
      exit;
    } 



   while($row3 = pg_fetch_row($ret3)){
        $directors = array('directorid' => $row3[0],
                            'directorname' => $row[1]);
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
                                 'directors' => $directors);
    }

        //TODO Replace the following with a database check
        $elem = array(
            'id' => '1'
            'name' => 'This is a movie',
            'time' => '1h30',
            'rating' => 5,
            'description' => 'This is a random description of a movie. Most movies contain a certain number of actors, named the cast, along with usually one or more directors and one or more studio. A good movie gets a good rating, whereas a bad movie gets a bad rating.',
            'year' => '1996',
            'studio' => 'Walt Disney',
            'director' => array('Martin Luther King'),
            'cast' => array('Angelina Jolie', 'Brad Pit', 'Will smith', 'Leonardo DiCaprio')
       );

        $response[] = array(
            'movie' => $elem,
            'timestamp' => 'Mon Mar 28 2016'
        );
    }

    echo json_encode($response);
}
?>