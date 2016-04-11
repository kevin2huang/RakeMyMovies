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

date_default_timezone_set('EST');
$date = date('j F Y');

//Homepage and search same usecase. 
if(isset($_GET['userId']) and isset($_GET['movieId'])) {
  $getreview = pg_query($db, "SELECT R.*
                FROM REVIEW R, RAKEUSER U, USRREV UR, MOVREV MR
                WHERE U.USER_ID = " . $_GET['userId'] . "AND 
                U.USER_ID = UR.USER_ID AND
                UR.REVIEW_ID = R.REVIEW_ID AND 
                R.REVIEW_ID = MR.REVIEW_ID AND 
                MR.MOVIE_ID = " . $_GET['movieId'] . ";");
  
  $getmoviename_query = pg_query($db, "SELECT MOVIE.TITLE
                     FROM MOVIES
                     WHERE MOVIE_ID = " . $_GET['movieId'] . ";");

  while(pg_fetch_row($getmoviename_query)){
    $movie_name = $row[0];
  }

  if(!$getreview){
    echo "EMPTY";
  }
  else
  {
    while($row = pg_fetch_row($getreview)){
      $thereview = array('moviename' => $movie_name,
      				'reviewid' => $row[0],
                'reviewdescription' => $row[1],
                'reviewrating' => $row[2],
                'reviewdate' => $row[3]);
    }
  }
  $rreviews = array('review' => $thereview);
  echo json_encode($rreviews);
  /*
  Get the rating and the description of the review between that user and that movie. If none
  are found, return the string 'EMPTY'
  */
} 
/* No movieId was passed, only the userId. Return every review written by this user*/
else if (isset($_GET['userId'])) {
  $reviews = array();
  $getreviews = pg_query($db, "SELECT DISTINCT M.MOVIE_TITLE, R.*
                FROM REVIEW R, RAKEUSER U, USRREV UR, MOVIES M, MOVREV MR
                WHERE U.USER_ID = " . $_GET['userId'] . " AND 
                U.USER_ID = UR.USER_ID AND
                UR.REVIEW_ID = R.REVIEW_ID AND 
                R.REVIEW_ID = MR.REVIEW_ID AND 
                MR.MOVIE_ID = M.MOVIE_ID;");

  if(!$getreviews){
    pg_last_error($db);
    exit;
  }

  while($row = pg_fetch_row($getreviews)){
    array_push($reviews, array('moviename' => $row[0],
              'reviewid' => $row[1],
              'reviewdescription' => $row[2],
              'reviewrating' => $row[3],
              'reviewdate' => $row[4]));
  }
  $rreviews = array('reviews' => $reviews);
  echo json_encode($rreviews);
} 

else if( isset($_POST['userId']) and isset($_POST['movieId']) and 
  isset($_POST['rating']) and isset($_POST['text'])) 
{

  /*If $_POST_['update'] is true, then a review already exists in the database between this user and that movie. Update its rating and description values*/
  if( isset($_POST['update']) and $_POST['update']) {
    $update_review = pg_query($db, "UPDATE REVIEW AS R
                    SET REVIEW_DESCRIPTION = '". $_POST['text'] . "',
                    REVIEW_RATING = " . $_POST['rating'] . "
                    FROM MOVIES M, MOVREV MR, RAKEUSER U, USRREV UR
                    WHERE M.MOVIE_ID = " . $_POST['movieId'] ." AND
                    MR.MOVIE_ID = M.MOVIE_ID AND
                    MR.REVIEW_ID = R.REVIEW_ID;");

    if(!$update_review){
      echo pg_last_error($db);
      exit;
    }
    echo "OK";
  } 
  /*Else, then no review previously exists between this user and that movie. Create a new review relation*/
  else  {
    $create_review = pg_query($db, "INSERT INTO REVIEW (REVIEW_DESCRIPTION, REVIEW_RATING, REVIEW_DATE)
                    VALUES 
                    ('" . $_POST['text'] . "'," . $_POST['rating'] . ", '" . $date . "');");


    $getreviewid = pg_query($db, "SELECT REVIEW_ID
                      FROM REVIEW
                      WHERE REVIEW_DESCRIPTION = " . "'" . $_POST['text'] . "'" . " AND 
                          REVIEW_RATING = " . $_POST['rating'] . " AND 
                          REVIEW_DATE = '" .  $date . "'" .";");

    while($row = pg_fetch_row($getreviewid)){
      $reviewid = $row[0];
    }

    echo "YEY";

    $create_user_review = pg_query($db, "INSERT INTO USRREV 
                       VALUES 
                       (" . $_POST['userId'] . ", " . $reviewid . ");");

    $create_movie_review = pg_query($db, "INSERT INTO MOVREV
                        VALUES 
                        (" . $_POST['movieId'] . ", " . $reviewid . ");");

    if(!$create_review or !$create_user_review or !$create_movie_review or !$getreviewid){
      echo pg_last_error($db);
      exit;
    }

    echo "OK";
  }
  
}
else
{
  echo "FAILED";
} 
pg_close($db);
/*$response = array();
 for ($i = 0; $i < 5; $i++) {
  $response[] = array(
    'description': 'This is a review. The description can be more or less long depending on the review. Most of the time, a review will be about one or two paragraphs long.',
    'rating': 5,
    'name': 'Anonymous'
    );*/
?>
