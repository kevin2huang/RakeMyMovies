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

	//TODO Connect with database

    $response->status = array('Horror', 'Action', 'Comedy', 'Documentary', 'New', 'Thriller', 'Animated', 'Drama', 'Western');

    $response->artists = array('Robert Downey Jr.', 'Tom Hanks', 'Jonny Depp', 'Tom Cruise', 'Will Smith', 'Brad Pitt', 'Morgan Freeman', 'George Clooney', 'Robin Williams');

    echo json_encode($response);
?>
