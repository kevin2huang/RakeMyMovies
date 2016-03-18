<?php
   $host        = "host=127.0.0.1";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=root";

   $db = pg_connect( "$host $port $dbname $credentials"  );

   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
      pg_query('SET search_path = "Test"');
   }

   $ret = pg_query($db, "SELECT * FROM MOVIES");
   if(!$ret){
      echo pg_last_error($db);
      exit;
   } 

   $result = array();

   while($row = pg_fetch_row($ret))
   {
     /* 
      echo "MOVIE_ID = ". $row[0] . "\n";
      echo "MOVIE_TITLE = ". $row[1] ."\n";
      echo "RELEASE_DATE = ". $row[2] ."\n";
      echo "DESCRIPTION =  ".$row[3] ."\n";
      echo "TG_RATING = " .$row[4] ." \n\n";

       */
      array_push($result, array('id' => $row[0], 
                                 'title' => $row[1], 
                                 'release_date' => $row[2], 
                                 'description' => $row[3], 
                                 'tg_rating' => $row[4]));
                                
   }
   $movarr = array('movies' => $result);
   echo json_encode($movarr);
   echo "Operation done successfully\n";
   pg_close($db);
?>