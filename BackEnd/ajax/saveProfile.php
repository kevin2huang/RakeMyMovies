<?php
 $host        = "host=web0.site.uottawa.ca";
   $port        = "port=15432";
   $dbname      = "dbname=khuan042"; //put your username here
   $credentials = "user=khuan042 password=Huang756!"; //put username + password here

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      pg_query('SET search_path = "RakeMyMovie";');
   }

$response;

if (!is_null($_POST['email']) and !is_null($_POST['password']) and !is_null($_POST['username']))
{
	$up_user = pg_query($db, "UPDATE RAKEUSER
							  SET USER_PASSWORD = " + $_POST['password'] + ", 
							  USER_EMAIL = " + $_POST['email'] + ", 
							  USER_NAME = " + $_POST['username'] + ", 
							  USER_GENDER " + $_POST['gender'] + ",
							  USER_DOB = " + $_POST['dob'] + ", 
							  USER_ICON = " + $_POST['icon'] + ",
							  USER_ISADMIN = " + $_POST['isadmin'] + ";");

	$up_profile = pg_query($db, "UPDATE PROFILE
								 SET PROFILE_PROVINCE = " + $_POST['province'] + ",
								 PROFILE_CITY =  " + $_POST['city'] + ",
								 PROFILE_COUNTRY =  " + $_POST['country'] + ", 
								 PROFILE_OCCUPATION =  " + $_POST['occupation'] + ",
								 PROFILE_QUOTE =  " + $_POST['quote'] + ";");

   if(!$up_user or !$up_profile)
   {
      echo pg_last_error($db);
      exit;
   } 
    $response->status = 'OK';
}
else
{
	$response->status = 'FAILED';
}
    echo json_encode($response);
?>
