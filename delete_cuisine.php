<?php

    // Connect to database
    include 'connect.php';

    // Take values
    $cuisine_id = $_GET['param'];

    echo "Le cuisine_id à supprimer est le ".$cuisine_id;

    // Insert information
    $sql = "DELETE FROM cuisine WHERE id=$cuisine_id";

    if ($conn->query($sql) === TRUE) {
    echo "La suppression a été effectuée";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Modify links
    $sql2 = "UPDATE linked_cuisine
    SET cuisine_id='1'
    WHERE cuisine_id=$cuisine_id";

    if ($conn->query($sql2) === TRUE) {
    echo "La modification a été effectuée";
    } else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
    }

    $conn->close();

    header('Location: cuisines.php');
    ?> 