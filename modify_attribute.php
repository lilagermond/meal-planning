<?php

    // Connect to database
    include 'connect.php';

    // Take values
    $attribute_name =  $_POST['attribute_name'];
    $attribute_id = $_POST['attribute_id'];
    $max_number = $_POST['max_number'];

    // Insert information
    $sql = "UPDATE attribute
            SET attribute_name='$attribute_name',max_number='$max_number'
            WHERE id=$attribute_id";
    echo "SQL: ".$sql;
    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully. <br> L'id modifié est le ".$attribute_id."<br> Le nom modifié est ".$attribute_name."<br>Le nombre max modifié est ".$max_number;
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    header('Location: attributes.php');
    ?> 