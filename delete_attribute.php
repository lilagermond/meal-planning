<?php

    // Connect to database
    include 'connect.php';

    // Take values
    $attribute_id = $_GET['param'];

    echo "Le attribute_id à supprimer est le ".$attribute_id;

    // Insert information
    $sql = "DELETE FROM attribute WHERE id=$attribute_id";

    if ($conn->query($sql) === TRUE) {
    echo "La suppression a été effectuée";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql2 = "DELETE FROM linked_attribute WHERE attribute_id=$attribute_id";

    if ($conn->query($sql2) === TRUE) {
    echo "La suppression a été effectuée";
    } else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
    }

    $conn->close();

    header('Location: attributes.php');
    ?> 