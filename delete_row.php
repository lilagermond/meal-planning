<?php

    // Connect to database
    include 'connect.php';

    // Take values
    $id = $_GET['id'];
    $table = $_GET['table'];

    echo "On souhaite supprimer l'id ".$id." dans la table ".$table;

    // Delete from the main table
    if ($table == "recipe"){
        $sql = "UPDATE recipe
                SET active=0
                WHERE id=$id";
    } else {
        $sql = "DELETE FROM $table WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
    echo "La suppression de la ligne a été effectuée";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Delete or modify the links in other tables
    if ($table != "recipe"){
    
        if ($table == "attribute"){
            $sql2 = "DELETE FROM linked_attribute 
                     WHERE attribute_id=$id";
        } else if ($table == "cuisine"){
            $sql2 = "UPDATE recipe
                     SET cuisine_id='1'
                     WHERE cuisine_id=$id";
        } else if ($table == "week") {
            $sql2 = "DELETE FROM week_historic 
                     WHERE week_id=$week_id";
        }
        
        if ($conn->query($sql2) === TRUE) {
            echo "Les suppressions liées ont été effectuées";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }

    }

    $conn->close();

    /*if ($table == "attribute"){
        header('Location: attributes.php');
    } else if ($table == "cuisine"){
        header('Location: cuisines.php');
    } else if ($table == "recipe"){
        header('Location: recipes.php');
    } else if ($table == "week"){
        header('Location: weeks.php');
    }*/

?> 

