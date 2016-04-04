<?php
header("content-type:application/json");
$response;

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

    echo json_encode($response);
?>
