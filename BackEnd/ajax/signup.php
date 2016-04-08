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
if(isset($_POST['email']) and isset($_POST['password'] and isset($_POST['username'])))
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

       $userid = pg_query($db, "SELECT USER_ID 
                                FROM RAKEUSER
                                WHERE USER_EMAIL = " + $_POST['email'] + ";");

        
              
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
     $user = array();
     $profile = array();
     while($row = pg_fetch_row($ret))
     {
              $user = array('userid' => $row[0], 
                                   'username' => $row[1], 
                                   'email' => $row[2],
                                   'password' => $row[3], 
                                   'gender' => $row[4],
                                   'dob' => $row[5]);
      }

      while($row2 = pg_fetch_row($ret2))
      {
          $profile = array('profileid' => $row2[0],
                                      'userid' => $row2[1],
                                      'province' => $row2[2],
                                      'city' => $row2[3],
                                      'occupation' => $row2[4],
                                      'country' => $row2[5],
                                      'quote' => $row2[6]);
      }
      $user_profile = array('user' => $user, 'profile' => $profile);
      echo json_encode($user_profile);
     // echo "Operation done successfully\n";
      pg_close($db);
  }
}
else
{
    echo "Wrong email/pass";
}

?>