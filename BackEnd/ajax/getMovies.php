<?php
header("content-type:application/json");
if(isset($_POST['movieIDs'])){

    $response = array();

    foreach ($_POST['movieIDs'] as $movieID) {
        //TODO Replace the following with a database check
        $elem = array(
            'name' => 'This is a movie',
            'time' => '1h30',
            'rating' => 5,
            'description' => 'This is a random description of a movie. Most movies contain a certain number of actors, named the cast, along with usually one or more directors and one or more studio. A good movie gets a good rating, whereas a bad movie gets a bad rating.',
            'year' => '1996',
            'studio' => 'Walt Disney',
            'director' => array('Martin Luther King'),
            'cast' => array('Angelina Jolie', 'Brad Pit', 'Will smith', 'Leonardo DiCaprio')
       );

        $response[] = array(
            'movie' => $elem,
            'timestamp' => 'Mon Mar 28 2016'
        );
    }

    echo json_encode($response);
}
?>