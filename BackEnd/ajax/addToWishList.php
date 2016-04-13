<?php
   $host        = "host=web0.site.uottawa.ca";
   $port        = "port=15432";
   $dbname      = "dbname=khuan042";
   $credentials = "user=khuan042 password=password1";

   $db = pg_connect( "$host $port $dbname $credentials"  );

   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      pg_query('SET search_path = "RakeMyMovie";');
   }

date_default_timezone_set('EST');
$date = date('j F Y');

if(isset($_POST['userId']) and isset($_POST['movieId']))
{
   if($_POST['listType'] === 'wish')
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
          echo 'OK';
          exit;
      }
   }
   else if($_POST['listType'] === 'watched')
   {
        //Insert the new wish relation between the user and the movie
        $add = pg_query($db, "INSERT INTO WATCHED (USER_ID, MOVIE_ID, WATCHED_TIMESTAMP)
                              VALUES 
                              (" . $_POST['userId'] . ", " . $_POST['movieId'] . ", " . "'" . $date . "'" . ");");

        if(!$add)
        {
            echo 'FAILED';
            exit;
        }
        else
        {
            echo 'OK';
           exit;
        }
    }
    else{
      echo "ERROR";
    }
  } 
  else 
  {
      echo 'FAILED';
      exit;
  }
    pg_close($db);
?>