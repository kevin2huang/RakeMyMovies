
/*
Search : Tom Hanks comedy GuMP

slit (seach) -> [..]

UPPER(MovieName) LIKE UPPER(‘%’ + $input[..] + ‘%’) OR

..(ActorName) OR
..(Genre)

=================
Inputs : array of strings
ex : ['Tom', 'Hanks,' 'comedy', 'GuMP']

Output : A list of all movies and movie info that contain of of those words in their Title, Actors, or Genre, and ranked by the number of word correspondences and ratings
=================

SELECT *.M, 
FROM Movie M


=================*/
<?php
/*   $host        = "host=web0.site.uottawa.ca";
   $port        = "port=15432";
   $dbname      = "dbname=khuan042"; //put your username here
   $credentials = "user=khuan042 password=Huang756!"; //put username + password here

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
      pg_query('SET search_path = "RakeMyMovies";');
   }*/

//array of movie IDs
header("content-type:application/json");

if(isset($_POST['movieIDs'])){

    foreach ($_POST['movieIDs'] as $movieID) {
         $ret = pg_query($db, "SELECT M.*, A.*, D.*, S.*, *G
                                 FROM MOVIES M, ACTOR A, MOVACT MA, DIRECTOR D, MOVDIR MD, STUDIO S, SPONSOR SP, MOVGEN MG, GENRE G
                                 WHERE A.ACTOR_ID = MA.ACTOR_ID AND
                                        MA.MOVIE_ID = M.MOVIE_ID AND
                                        D.DIRECTOR_ID = MD.DIRECTOR_ID AND 
                                        MD.MOVIE_ID = M.MOVIE_ID AND 
                                        SP.MOVIE_ID = M.MOVIE_ID AND 
                                        SP.STUDIO_ID = S.STUDIO_ID AND
                                        (UPPER(M.MOVIE_TITLE) LIKE UPPER(%" + $input+ "%) OR
                                        UPPER(G.NAME) LIKE UPPER(%" + $input+ "%) OR
                                        UPPER(A.NAME) LIKE UPPER(%" + $input+ "%) OR
                                        );")
 
 	}

    //echo json_encode($response);
}
?>