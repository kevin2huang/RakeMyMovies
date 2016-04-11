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

$_POST['movieid']
$_POST['directors'] = array();
$_POST['genres'] = array(3,6,9);

if(isset($_POST['movieid'])){
	$delete_movdir = pg_query($db, "DELETE 
									FROM MOVDIR
									WHERE MOVIE_ID = " . $_POST['movieid'] . ";");

	$delete_movgen = pg_query($db, "DELETE 
									FROM MOVGEN
									WHERE MOVIE_ID = " . $_POST['movieid'] . ";");

	if(!is_null($_POST['directors']){

		foreach($director as $_POST['directors']){
			$insert_movdir = pg_query($db, "INSERT INTO MOVDIR 
											VALUES 
											(" . $_POST['movieid'] . ", " . $director . ");");

			if(!$insert_movdir){
				echo pg_last_error($db);
				exit;
			}
		}


	}

	if(!is_null($_POST['genres']){

		foreach($genre as $_POST['genres']){
			$insert_movgen = pg_query($db, "INSERT INTO MOVGEN 
											VALUES 
											(" . $_POST['movieid'] . ", " . $genre . ");");
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
/*
	Update movie

	$_POST = {
		directors : ['Name 1', 'Name 2', ...],
		genres : ['Genre 1', 'Genre 2', ...]
	}
*/
?>