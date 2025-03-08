<?php

    // Connect to database
    include 'connect.php';

    // Take values
    $week_id = $_GET['param'];

    echo "La semaine à supprimer est la ".$week_id;

    // Insert information
    $sql = "DELETE FROM week WHERE id=$week_id";

    if ($conn->query($sql) === TRUE) {
    echo "La suppression a été effectuée";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql2 = "DELETE FROM week_historic WHERE week_id=$week_id";

    if ($conn->query($sql2) === TRUE) {
    echo "La suppression a été effectuée";
    } else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
    }

    $conn->close();

    //header('Location: weeks.php');
    ?> 