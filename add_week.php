<?php
    
    // Connect to database
    include 'connect.php';

    // Take values
    $meal_number = $_REQUEST['meal_number'];
    $date =  $_REQUEST['date'];

    // Insert information
    $sql = "INSERT INTO week (date, meal_number)
    VALUES ('$date','$meal_number');";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "New record created successfully <br> Last inserted ID is: " . $last_id;
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    };

    if(!empty($_REQUEST['choosen_recipe'])) {
        foreach ($_REQUEST['choosen_recipe'] as $choosen_recipe) {
            echo $choosen_recipe . '<br>';

            $sql2 = "INSERT INTO week_historic (week_id, recipe_id)
            VALUES ('$last_id','$choosen_recipe')";

            if ($conn->query($sql2) === TRUE) {
                echo "New attribute created successfully";
                } else {
                echo "Error: " . $sql2 . "<br>" . $conn->error;
            };
        }
    } else {
        echo "No choosen recipe";
    };

    
    $conn->close();

    //header('Location: weeks.php');
    ?> 