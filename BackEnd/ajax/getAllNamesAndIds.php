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
  
  $response = array();
  $movies = array();
  $directors = array();
  $genres = array();

  $list = pg_query($db, "SELECT M.MOVIE_TITLE, M.MOVIE_ID
                                 FROM MOVIES M;");


  while ($row = pg_fetch_row($list)){
    array_push($movies, array(
      'name'=> $row[0],
      'id' => $row[1]));
  }

  $list = pg_query($db, "SELECT D.DIR_NAME, D.DIR_ID
                                 FROM DIRECTOR D;");


  while ($row = pg_fetch_row($list)){
    array_push($directors, array(
      'name'=> $row[0],
      'id' => $row[1]));
  }

  $list = pg_query($db, "SELECT G.GENRE_NAME, G.GENRE_ID
                                 FROM GENRE G;");


  while ($row = pg_fetch_row($list)){
    array_push($genres, array(
      'name'=> $row[0],
      'id' => $row[1]));
  }

  $response = array(
    'movies' => $movies,
    'directors' => $directors,
    'genres' => $genres
    );
  
 
    echo json_encode($response);
?>