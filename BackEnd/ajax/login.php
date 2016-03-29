<?php
header("content-type:application/json");
if(isset($_POST['username']) and isset($_POST['password'])){
    //TODO Replace the following with a database check
    if ($_POST['username'] == 'Abigael' and $_POST['password'] == '1234') {
    	$pg1 = array
       (
            'username' => 'Abigael',
            'password' => '1234',
            'email' => 'abigael.tremblay@gmail.com',
            'country' => 'Canada',
            'province' => 'Ontario',
            'city' => 'Ottawa',
            'occupation' => 'Student',
            'quote' => 'Today is such a nice day!'
       );

		echo json_encode($pg1);
    }

}
?>