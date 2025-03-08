<?php

    // Connect to database
    include 'connect.php';

    // Take values
    $cuisine_name =  $_POST['cuisine_name'];
    $cuisine_id = $_POST['cuisine_id'];

    // Insert information
    $sql = "UPDATE cuisine
            SET cuisine_name='$cuisine_name'
            WHERE id=$cuisine_id";
    echo "SQL: ".$sql;
    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully. <br> L'id créé est le ".$cuisine_id."<br> Le nom modifié est ".$cuisine_name;
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    header('Location: cuisines.php');
    ?> 