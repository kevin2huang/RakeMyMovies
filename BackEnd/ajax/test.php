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

 $_POST['userId'] = 10;

 if(isset($_POST['userId']))
    {
      $ch3_genreids = array();
      //Channel 2: Movies based on a users favorite genre
      $ch3_genreids_query = pg_query($db, "SELECT G.GENRE_ID 
                          FROM GENRE G, RAKEUSER U, USRGEN UG
                          WHERE U.USER_ID = " . $_POST['userId'] . " AND 
                          UG.USER_ID = U.USER_ID AND 
                          UG.GENRE_ID = G.GENRE_ID");
      
      while($row = pg_fetch_row($ch3_genreids_query)){
        array_push($ch3_genreids, $row[0]);
      }
   print_r($ch3_genreids);

}
?>