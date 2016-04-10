<?php

   $host        = "host=web0.site.uottawa.ca";
   $port        = "port=15432";
   $dbname      = "dbname=khuan042"; //put your username here
   $credentials = "user=khuan042 password=Huang756!"; //put username + password here

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      pg_query('SET search_path = "RakeMyMovie";');
   }

// isset = boolean to see if ___ exists

if(isset($_POST['email']) and isset($_POST['password']) and isset($_POST['username']) and isset($_POST['dob']))
{
       $insert_user = pg_query($db, "INSERT INTO RAKEUSER (USER_NAME, USER_EMAIL, USER_PASSWORD, USER_GENDER, USER_DOB, USER_ICON, USER_ISADMIN)
                                     VALUES 
                                     (" . "'" . $_POST['username'] . "'" . ", 
                                      " . "'" . $_POST['email'] . "'" . ", 
                                      ". "'" . $_POST['password'] . "'" . ", 
                                      ". "'" . $_POST['gender'] . "'" . ", 
                                      " . "'" . $_POST['dob'] . "'" . ",
                                      ". "'" . $_POST['icon'] . "'" . ",
                                      " . $_POST['isadmin'] . ");");

       $userid_q = pg_query($db, "SELECT USER_ID 
                                  FROM RAKEUSER
                                  WHERE USER_EMAIL = " . "'" . $_POST['email'] . "'" . ";");

       $userid = pg_fetch_row($userid_q);

       $insert_profile = pg_query($db, "INSERT INTO PROFILE (USER_ID, PROFILE_PROVINCE, PROFILE_CITY, PROFILE_OCCUPATION, PROFILE_COUNTRY, PROFILE_QUOTE)
                                         VALUES 
                                         (". $userid[0] . ", 
                                          ". "'" . $_POST['province']. "'" . ", 
                                          ". "'" . $_POST['city']. "'" . ", 
                                          ". "'" . $_POST['occupation']. "'" . ", 
                                          " . "'" . $_POST['country'] . "'" . ", 
                                          ". "'" . $_POST['quote'] . "'" . ");");

   if(!$insert_user or !$userid_q or !$insert_profile)
   {
      echo pg_last_error($db);
      exit;
   }
   else
   {
      echo "OK";
      pg_close($db);
  }
}
else
{
    echo "FAILED";
}
?>