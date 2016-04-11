  <?php
   $host        = "host=web0.site.uottawa.ca";
   $port        = "port=15432";
   $dbname      = "dbname=khuan042";
   $credentials = "user=khuan042 password=Huang756!";

   $db = pg_connect( "$host $port $dbname $credentials");

   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      pg_query('SET search_path = "RakeMyMovie";');
   }

//$_POST['movieid'];
//$_POST['directors'] = array();
//$_POST['genres'] = array(3,6,9);

if(isset($_POST['movieId'])){
	$delete_movdir = pg_query($db, "DELETE 
									FROM MOVDIR
									WHERE MOVIE_ID = " . $_POST['movieId'] . ";");

	$delete_movgen = pg_query($db, "DELETE 
									FROM MOVGEN
									WHERE MOVIE_ID = " . $_POST['movieId'] . ";");

	if(isset($_POST['directors'])){
		foreach($_POST['directors'] as $director){
			$insert_movdir = pg_query($db, "INSERT INTO MOVDIR 
											VALUES 
											(" . $_POST['movieId'] . ", " . $director['directorid'] . ");");

			if(!$insert_movdir){
				echo pg_last_error($db);
				exit;
			}
		}


	}

	if(!is_null($_POST['genres'])){

		foreach($_POST['genres'] as $genre){
			$get_mov_gen = pg_query($db, "SELECT GENRE_ID 
											FROM GENRE
											WHERE GENRE_NAME = '" . $genre ."';");

			while($row = pg_fetch_row($get_mov_gen)) {
				$genre_id = $row[0];
			}

			$insert_movgen = pg_query($db, "INSERT INTO MOVGEN 
											VALUES 
											(" . $_POST['movieId'] . ", " . $genre_id . ");");
			if(!$insert_movgen){
				echo pg_last_error($db);
				exit;
			}
		}
	}

	if(!$delete_movdir or !$delete_movgen){
		echo pg_last_error($db);
		exit;
	}

	echo "OK";
}
else
{
	echo "FAILED";
}
pg_close($db);
/*
	Update movie

	$_POST = {
		directors : ['Name 1', 'Name 2', ...],
		genres : ['Genre 1', 'Genre 2', ...]
	}
*/
?>