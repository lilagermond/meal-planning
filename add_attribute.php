<?php

    // Connect to database
    include 'connect.php';

    // Take values
    $attribute_name =  $_REQUEST['attribute_name'];
    $max_number =  $_REQUEST['max_number'];

    // Insert information
    $sql = "INSERT INTO attribute (attribute_name, max_number)
    VALUES ('$attribute_name', '$max_number')";

    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    header('Location: attributes.php');
    ?> 