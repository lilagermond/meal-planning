<?php

function get_cuisine_name(){

}

function get_select($type,$multiple,$action,$rec_id){
    include 'connect.php';

    echo " <select name=\"$type\" ";

    if ($multiple == true){
        echo "multiple=\"multiple\"";
    }
    
    echo ">";

    // Déclaration de la requête SQL à prendre en compte en fonction du select que l'on souhaite afficher
    if ($type == "cuisine_name") {
        $query = mysqli_query($conn,'SELECT id,cuisine_name FROM cuisine');
    } else if ($type == "season_id[]"){
        $query = mysqli_query($conn,'SELECT id,
                    CASE WHEN season_name = "all" THEN "Toutes saisons"
                    WHEN season_name = "winter" THEN "Hiver"
                    WHEN season_name = "spring" THEN "Printemps"
                    WHEN season_name = "summer" THEN "Eté"
                    WHEN season_name = "autumn" THEN "Automne" END
                    FROM season');
    } else if ($type == "attribute_id[]") {
        $query = mysqli_query($conn,'SELECT id,attribute_name FROM attribute');
    } 
                            
    if (mysqli_num_rows($query)==0)
        {
            echo "No rows returned";
        }
    else {
        // Ecriture des différentes lignes
        while($write_cuisine=mysqli_fetch_row($query)){
            if ($type != "cuisine_name" || ($type == "cuisine_name" && $write_cuisine[0] != '1')) {

                // Dans le cas d'une création, on affiche les différentes options possibles
                if ($action=="create"){
                    
                    echo "<option value=\"$write_cuisine[0]\">$write_cuisine[1]</option>";
                
                // Dans le cas d'une modification, si les valeurs étaient précédemment sélectionnées, alors on les resélectionne
                } else if ($action=="modify"){

                    echo "<option value=\"$write_cuisine[0]\" ";

                    if ($type == "cuisine_name") {
                        $selected = mysqli_query($conn,"SELECT 1 FROM recipe WHERE id = $rec_id and cuisine_id = $write_cuisine[0]");
                    } else if ($type == "season_id[]"){
                        $selected = mysqli_query($conn,"SELECT 1 FROM linked_season WHERE recipe_id = $rec_id and season_id = $write_cuisine[0]");
                    } else if ($type == "attribute_id[]"){
                        $selected = mysqli_query($conn,"SELECT 1 FROM linked_attribute WHERE recipe_id = $rec_id and attribute_id = $write_cuisine[0]");
                    }

                    
                    if (mysqli_num_rows($selected)!=0) {
                        echo "selected";
                    } 
                        
                    echo ">$write_cuisine[1]</option>";

                }
            }
        }
    };

    echo "</select>";
}

?>

