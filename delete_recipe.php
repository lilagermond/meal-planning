<?php

    // Connect to database
    include 'connect.php';

    // Take values
    $recipe_id = $_GET['param'];

    echo "Le cuisine_id à désactiver est le ".$recipe_id;

    // Insert information
    $sql = "UPDATE recipe
    SET active=0
    WHERE id=$recipe_id";

    if ($conn->query($sql) === TRUE) {
    echo "La suppression a été effectuée";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    header('Location: recipes.php');
    ?> 