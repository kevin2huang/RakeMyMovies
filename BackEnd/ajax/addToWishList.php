<?php
header("content-type:application/json");
    //echo json_encode(array( 'movies' => "Yep"));
$response;

//if(isset($_POST['userId']) && isset($_POST['movieId'])){
    //Insert the new wish relation between the user and the movie
    $response->status = 'OK';
//} else {
    //$response->status = 'FAILED';
//}
    echo json_encode($response);
?>