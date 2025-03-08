<?php

    // Connect to database
    include 'connect.php';

    // Take values
    $cuisine_name =  $_REQUEST['cuisine_name'];

    // Insert information
    $sql = "INSERT INTO cuisine (cuisine_name)
    VALUES ('$cuisine_name')";

    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    header('Location: cuisines.php');
    ?> 