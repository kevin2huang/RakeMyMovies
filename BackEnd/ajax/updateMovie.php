  <?php
   $host        = "host=web0.site.uottawa.ca";
   $port        = "port=15432";
   $dbname      = "dbname=khuan042";
   $credentials = "user=khuan042 password=Huang756!";

   $db = pg_connect( "$host $port $dbname $credentials"  );

   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      pg_query('SET search_path = "RakeMyMovie";');
   }

$_POST['directors'] 
$_POST['genres']

if(isset())
/*
	Update movie

	$_POST = {
		directors : ['Name 1', 'Name 2', ...],
		genres : ['Genre 1', 'Genre 2', ...]
	}
*/
?>