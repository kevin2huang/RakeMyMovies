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
$response;

if ($email, $password, $username is not null){
 $ret = pg_query($db, "ALTER TABLE RAKEUSER U, PROFILE P
						ALTER COLUMN U.USER_PASSWORD SET " + $password + 
						"ALTER COLUMN U.USER_EMAIL SET " + $email + 
						";");

if(!$ret or !$ret2)
   {
      echo pg_last_error($db);
      exit;
   } 
	/*For each value of the data received, updata the tables for user and/or profile accordingly. 
	Such values you may care about are : 
		username
		password
		email
		country
		province
		city
		occupation
		gender
		quote
		userId
	*/

    $response->status = 'OK';
}
    echo json_encode($response);
?>
