<?php

include 'connect.php';

function add_cuisine(){

    // Take values
    $cuisine_name =  $_REQUEST['cuisine_name'];
    if(isset($_POST['exclusive'])) {
        $exclusive = true;
    } else $exclusive = false;

    // Insert information
    $sql = "INSERT INTO cuisine (cuisine_name, exclusive)
    VALUES ('$cuisine_name','$exclusive')";
}
?>

