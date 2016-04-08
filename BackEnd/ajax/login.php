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
if(isset($_POST['email']) and isset($_POST['password'])){
       $ret = pg_query($db, "SELECT * 
                             FROM RAKEUSER U 
                             WHERE U.USER_EMAIL = " + $_POST['email'] + " AND 
                             U.USER_PASSWORD = " + $POST['password'] + ";");

       $ret2 = pg_query($db, "SELECT * 
                              FROM PROFILE P 
                              WHERE P.USER_ID = (SELECT U.USER_ID 
                                     FROM RAKEUSER U 
                                     WHERE U.USER_EMAIL = " + $_POST['email'] +" AND 
                                     U.USER_PASSWORD = "+ $_POST['password'] + ");");
   if(!$ret){
      echo pg_last_error($db);
      exit;
   } 
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
else{
    echo "Wrong email/pass";
}

?>