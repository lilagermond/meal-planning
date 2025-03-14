<?php

    // Connect to database
    include 'connect.php';

    $table = $_GET['table'];
    $action = $_GET['action'];

    if ($table == "attribute") {

        // Retrieve form values
        $attribute_name =  $_REQUEST['attribute_name'];
        $max_number =  $_REQUEST['max_number'];

        // Insert or modify information
        if($action == "create") {

            $sql = "INSERT INTO attribute (attribute_name, max_number)
                    VALUES ('$attribute_name', '$max_number')";

        } else if ($action == "modify"){

            $attribute_id = $_POST['attribute_id'];

            $sql = "UPDATE attribute
            SET attribute_name='$attribute_name',max_number='$max_number'
            WHERE id=$attribute_id";
        }

    } else if ($table == "cuisine") {

        // Retrieve form values
        $cuisine_name =  $_REQUEST['cuisine_name'];

        // Insert or modify information
        if($action == "create") {

            $sql = "INSERT INTO cuisine (cuisine_name)
                    VALUES ('$cuisine_name')";

        } else if ($action == "modify"){

            $cuisine_id = $_POST['cuisine_id'];

            $sql = "UPDATE cuisine
            SET cuisine_name='$cuisine_name'
            WHERE id=$cuisine_id";
        }

    }  else if ($table == "recipe") {

        // Retrieve form values
        $recipe_name =  $_REQUEST['recipe_name'];
        $cuisine_id = $_REQUEST['cuisine_name'];

        // Insert or modify information
        if($action == "create") {

            $sql = "INSERT INTO recipe (recipe_name, cuisine_id)
            VALUES ('$recipe_name','$cuisine_id');";


        } else if ($action == "modify"){

            $recipe_id = $_POST['recipe_id'];

            $sql = "UPDATE recipe
            SET recipe_name='$recipe_name', cuisine_id = $cuisine_id
            WHERE id=$recipe_id";
        }
    } else if ($table == "week") {

        // Retrieve form values
        $meal_number = $_REQUEST['meal_number'];
        $date =  $_REQUEST['date'];

        // Insert or modify information
        if($action == "create") {

            $sql = "INSERT INTO week (date, meal_number)
            VALUES ('$date','$meal_number');";

        } else if ($action == "modify"){

            $cuisine_id = $_POST['cuisine_id'];

            $sql = "UPDATE cuisine
            SET cuisine_name='$cuisine_name'
            WHERE id=$cuisine_id";
        }
        
    } 


    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";

        if ($action == "create" && ($table == "recipe" || $table == "week")){
            $last_id = $conn->insert_id;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


    // Insert information in other tables
    if ($table == "recipe") {

        if($action == "create") {

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

        } else if ($action == "modify"){

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

        }

    } else if ($table == "week") {

        if($action == "create") {

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

        } 
        
    } 


    $conn->close();

    // Return to the page
    if ($table == "attribute"){
        header('Location: attributes.php');
    } else if ($table == "cuisine"){
        header('Location: cuisines.php');
    } else if ($table == "recipe"){
        header('Location: recipes.php');
    } else if ($table == "week"){
        header('Location: weeks.php');
    }

?> 