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
	$ret = pg_query($db, "SELECT G.* 
						  FROM GENRE G, USRGEN UG
						  WHERE UG.USER_ID = " + $userid + " AND 
						  UG.GENRE_ID = G.GENRE_ID;");

	$ret2 = pg_query($db, "SELECT A.* 
						  FROM ACTOR A, USRACT UA
						  WHERE UA.USER_ID = " + $userid + " AND 
						  UA.ACTOR_ID = A.ACTOR_ID;");

	if(!$ret or !$ret2){
      echo pg_last_error($db);
      exit;
    } 

    while($row = pg_fetch_row($ret))
   {
            $genres = array('genreid' => $row[0], 
                           'genre' => $row[1]);
    }

    while($row2 = pg_fetch_row($ret2))
   {
            $actors = array('actorid' => $row[0], 
                           'actorname' => $row[1]);
    }

    $subscriptions = array('genres' => $genres, 'actors' => $actors);

    echo json_encode($subscriptions);
?>
