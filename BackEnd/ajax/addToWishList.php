<?php
   $host        = "host=web0.site.uottawa.ca";
   $port        = "port=15432";
   $dbname      = "dbname=khuan042";
   $credentials = "user=khuan042 password=Huang756!";

   $db = pg_connect( "$host $port $dbname $credentials"  );

   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      pg_query('SET search_path = "RakeMyMovie";');
   }

date_default_timezone_set('EST');
$date = date('j F Y');

$response;

if(isset($_POST['userId']) && isset($_POST['movieId']))
{
    //Insert the new wish relation between the user and the movie
    $add = pg_query($db, "INSERT INTO WISH (USER_ID, MOVIE_ID, WISH_TIMESTAMP)
						              VALUES 
                          (" . $_POST['userId'] . ", " . $_POST['movieId'] . ", " . "'" . $date . "'" . ");");

    if(!$add)
    {
        echo 'FAILED';
        exit;
    }
    else
    {
      $response = 'OK';
    }
    
  } 
  else 
  {
      $response = 'FAILED';
  }
    echo json_encode($response);
?>