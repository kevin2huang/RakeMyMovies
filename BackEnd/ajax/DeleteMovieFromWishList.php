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

if(isset($_POST['userId']) and isset($_POST['movieId'])){
    //Insert the new wish relation between the user and the movie
   if($_POST['listType'] === 'wish')
   {
    $delete = pg_query($db, "DELETE FROM WISH
                             WHERE MOVIE_ID = " . $_POST['movieId'] . " AND 
                             USER_ID = " . $_POST['userId'] . ";");


    echo 'DELETED';
   }
   elseif ($_POST['listType'] === 'watched') {
     $delete = pg_query($db, "DELETE FROM WATCHED
                             WHERE MOVIE_ID = " . $_POST['movieId'] . " AND 
                             USER_ID = " . $_POST['userId'] . ";");

    echo'DELETED';
   }
   else{
    echo "ERROR";
   }
}
else 
{
    echo 'FAILED';
}
    pg_close($db);
?>