<?php
    
    // Connect to database
    include 'connect.php';

    // Take values
    $recipe_id = $_POST['recipe_id'];
    $recipe_name =  $_REQUEST['recipe_name'];
    $cuisine_id = $_REQUEST['cuisine_name'];
    

    // Modify information in recipe table
    $sql = "UPDATE recipe
            SET recipe_name='$recipe_name', cuisine_id = $cuisine_id
            WHERE id=$recipe_id";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "Update successful. <br> Modified ID is: " . $recipe_id;
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    };

    // Supression of the existing seasons and creation of updated seasons in the linked_attribute

    $sql2 = "DELETE FROM linked_season WHERE recipe_id=$recipe_id";

        if ($conn->query($sql2) === TRUE) {
        echo "La suppression des saisons a été effectuée";
        } else {
        echo "Error: " . $sql2 . "<br>" . $conn->error;
        };
    

    if(empty($_POST['season_id'])) {
        $sql3 = "INSERT INTO linked_season (recipe_id, season_id)
            VALUES ('$recipe_id','1')";

            if ($conn->query($sql3) === TRUE) {
                    echo "New season created successfully";
                } else {
                echo "Error: " . $sql3 . "<br>" . $conn->error;
            };
    } else {
        foreach ($_POST['season_id'] as $season_id) {

            $sql4 = "INSERT INTO linked_season (recipe_id, season_id)
            VALUES ('$recipe_id','$season_id')";

            if ($conn->query($sql4) === TRUE) {
                    echo "New season created successfully";
                } else {
                echo "Error: " . $sql4 . "<br>" . $conn->error;
            };
        }
    };


    // Supression of the existing attributes and creation of updated attributes in the linked_attribute

    $sql5 = "DELETE FROM linked_attribute WHERE recipe_id=$recipe_id";

        if ($conn->query($sql5) === TRUE) {
        echo "La suppression des attributs a été effectuée";
        } else {
        echo "Error: " . $sql5 . "<br>" . $conn->error;
        }

    if(!empty($_POST['attribute_id'])) {
        foreach ($_POST['attribute_id'] as $attribute_id) {

            $sql6 = "INSERT INTO linked_attribute (recipe_id, attribute_id)
            VALUES ('$recipe_id','$attribute_id')";

            if ($conn->query($sql6) === TRUE) {
                echo "New attribute created successfully";
                } else {
                echo "Error: " . $sql6 . "<br>" . $conn->error;
            };
        }
    };
    
    $conn->close();

    header('Location: recipes.php');
    ?> 