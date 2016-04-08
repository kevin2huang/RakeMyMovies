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
    //echo json_encode(array( 'movies' => "Yep"));

if(isset($_POST['userId'])){
    //Do something if the user is set
    
} else {
    //Do another search if the user is not set. Select different channels, top rated and so on
}
    $channels = array();
        
    //TODO Replace the following with a database check
    for ($i = 0; $i < 5; $i++) {
        $channel = array();

        for ($j = 0; $j < 6; $j++) {
            $elem = array(
                'name' => 'This is a movie',
                'time' => '1h30',
                'rating' => 5,
                'description' => 'This is a random description of a movie. Most movies contain a certain number of actors, named the cast, along with usually one or more directors and one or more studio. A good movie gets a good rating, whereas a bad movie gets a bad rating.',
                'year' => '1996',
                'studio' => 'Walt Disney',
                'director' => array('Martin Luther King'),
                'cast' => array('Angelina Jolie', 'Brad Pit', 'Will smith', 'Leonardo DiCaprio')
           );

            $channel[] = $elem;
        }
        $channels[] = array('movies' => $channel);
    }

    $response = array('channels' => $channels);

    echo json_encode($response);
?>