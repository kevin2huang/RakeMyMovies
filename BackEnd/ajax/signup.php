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
// isset = boolean to see if ___ exists

$_POST['username'] = 'kevin2huang';
$_POST['email'] = 'kevin@hotmail.com';
$_POST['password'] = '1234';
$_POST['gender'] = 'M';
$_POST['DOB'] = 'feb 17 1994';
$_POST['icon'] = 'icon1.png';
$_POST['isadmin'] = TRUE;
$_POST['province'] = 'ON';
$_POST['city'] = 'Ottawa';
$_POST['occupation'] = 'Student';
$_POST['country'] = 'Canada';
$_POST['quote'] = 'What a nice day';

if(isset($_POST['email']) and isset($_POST['password']) and isset($_POST['username']))
{
       $insert_user = pg_query($db, "INSERT INTO RAKEUSER (USER_NAME, USER_EMAIL, USER_PASSWORD, USER_GENDER, USER_DOB, USER_ICON, USER_ISADMIN)
                                     VALUES 
                                     (" + $_POST['username'] + ", 
                                      " + $_POST['email'] + ", 
                                      "+ $_POST['password'] + ", 
                                      "+ $_POST['gender'] + ", 
                                      "+ $_POST['DOB'] + ", 
                                      "+ $_POST['icon'] + ", 
                                      "+ $_POST['isadmin'] + ");");

       $userid_q = pg_query($db, "SELECT USER_ID 
                                  FROM RAKEUSER
                                  WHERE USER_EMAIL = " + $_POST['email'] + ";");
 
       $userid = pg_fetch_row($userid_q);
       
       $insert_profile = pg_query($db, "INSERT INTO TABLE PROFILE (USER_ID, PROFILE_PROVINCE, PROFILE_CITY, PROFILE_OCCUPATION, PROFILE_COUNTRY, PROFILE_QUOTE)
                                         VALUES 
                                         (" + $userid + ", 
                                          " + $_POST['province'] + ", 
                                          "+ $_POST['city'] + ", 
                                          "+ $_POST['occupation'] + ", 
                                          "+ $_POST['country'] + ", 
                                          "+ $_POST['quote'] + ");");
    


   if(!$insert_user or !$insert_profile)
   {
      echo pg_last_error($db);
      exit;
   } 
   else
   {
      echo "INSERTED";
      pg_close($db);
  }
}
else
{
    echo "FAILED";
}

?>