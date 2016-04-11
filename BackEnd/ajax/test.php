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

    $num = getMovieRating(10, $db);
    echo $num;

pg_close($db);
/*$response = array();
 for ($i = 0; $i < 5; $i++) {
  $response[] = array(
    'description': 'This is a review. The description can be more or less long depending on the review. Most of the time, a review will be about one or two paragraphs long.',
    'rating': 5,
    'name': 'Anonymous'
    );*/
?>
