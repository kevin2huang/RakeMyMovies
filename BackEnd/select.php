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

   $sql =<<<EOF
      SELECT * from MOVIES;
EOF;

   $ret = pg_query($db, $sql);
   if(!$ret){
      echo pg_last_error($db);
      exit;
   } 
   while($row = pg_fetch_row($ret)){
      echo "MOVIE_ID = ". $row[0] . "\n";
      echo "MOVIE_TITLE = ". $row[1] ."\n";
      echo "RELEASE_DATE = ". $row[2] ."\n";
      echo "DESCRIPTION =  ".$row[4] ."\n"
      echo "TG_RATING = " .$row[5] ." \n\n";
   }
   echo "Operation done successfully\n";
   pg_close($db);
?>