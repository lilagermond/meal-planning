<?php
    
    // Connect to database
    include 'connect.php';

    // Take values
    $recipe_name =  $_REQUEST['recipe_name'];
    $cuisine_id = $_REQUEST['cuisine_name'];


    // Insert information
    $sql = "INSERT INTO recipe (recipe_name, cuisine_id)
    VALUES ('$recipe_name','$cuisine_id');
    ";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "New record created successfully <br> Last inserted ID is: " . $last_id;
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    };


    if(!empty($_POST['attribute_id'])) {
        foreach ($_POST['attribute_id'] as $attribute_id) {
            echo "Attribut à crééer : ".$attribute_id . 'Créer sur le recipe_id :   ' . $last_id . '<br>';

            $sql2 = "INSERT INTO linked_attribute (recipe_id, attribute_id)
            VALUES ('$last_id','$attribute_id')";

            if ($conn->query($sql2) === TRUE) {
                echo "New attribute created successfully";
                } else {
                echo "Error: " . $sql2 . "<br>" . $conn->error;
            };
        }
    }

    if(!empty($_POST['season_id'])) {
        foreach ($_POST['season_id'] as $season_id) {

            $sql3 = "INSERT INTO linked_season (recipe_id, season_id)
            VALUES ('$last_id','$season_id')";

            if ($conn->query($sql3) === TRUE) {
                    echo "New season created successfully";
                } else {
                echo "Error: " . $sql3 . "<br>" . $conn->error;
            };
        }
    } else {
        $sql4 = "INSERT INTO linked_season (recipe_id, season_id)
            VALUES ('$last_id','1')";

            if ($conn->query($sql4) === TRUE) {
                    echo "New season created successfully";
                } else {
                echo "Error: " . $sql4 . "<br>" . $conn->error;
            };
    }
    
    $conn->close();

   //header('Location: recipes.php');
    ?> 