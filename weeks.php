<html>
    <head>
        <title>Générateur de repas</title>
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src='script.js'> </script>
        <?php include 'connect.php'?>
    </head>
    <body>

        <!-- Menu -->   
        <?php include 'header.php' ?> 

        <!-- Semaines  -->
        <main id="weeks">
            <div id="create_week">
                <h2>Créer une nouvelle semaine</h2>
                <form action="add_week.php" onsubmit="return validate_week_form()">
                    Nombre de jours : <input type="number" id="meal_number" name="meal_number"><br>
                    Date: <input type="date" name="date"><br>


                    <div id="choose_recipes" class="table-flex">
                        <?php
                        $query_cuisine = mysqli_query($conn,'SELECT id, cuisine_name FROM cuisine');

                        if (mysqli_num_rows($query_cuisine)==0)
                        {
                            echo "<div>
                            No rows returned
                            </div>";
                        }
                        else
                            {
                                // On récupère sur la première ligne tous les types de recette
                                while($row=mysqli_fetch_row($query_cuisine))
                                {
                                    echo "<div>";
                                        echo "<div class=\"cell-head\"> $row[1] </div>";
                                    
                                    $cuisine_id = $row[0];
                                    $query_recipes = mysqli_query($conn,"SELECT r.id, r.recipe_name FROM recipe r where r.cuisine_id = '$cuisine_id'");

                                    if (mysqli_num_rows($query_recipes)==0)
                                    {
                                        echo "<div class=\"cell-body\">
                                                Pas de recettes
                                                </div>";
                                    }
                                    else
                                        {
                                            // On récupère sur les lignes suivantes toutes les recettes qui correspondent à ce type de cuisine
                                            echo "<div class=\"cell-body\">";
                                            while($row2=mysqli_fetch_row($query_recipes))
                                            {
                                                echo "<input type=\"checkbox\" name=\"choosen_recipe[]\" value=\"$row2[0]\"/> $row2[1] <br>";

                                            }
                                            echo "</div>";
                                        }
                                        echo "</div>";
                                    }
                                echo "</div>";
                            }
                        ?>
                    </div>
                    
                    
                    <button>Valider la semaine</button>
                    <span class="invisible red" id="missing_recipes">Pas assez de recettes sélectionnées</span>
                </form>
        
            </div>

            <div id="view_past_weeks">
                <h2>Menus des semaines passées</h2>
                <div>
                    <div id="table-week" class="table bold">
                        <div>Semaine</div>
                        <div>Recettes</div>
                        <div>Supprimer</div>
                    </div>
                    <?php
                        $query = mysqli_query($conn,'SELECT w.id, w.date FROM week w');

                        if (mysqli_num_rows($query)==0)
                        {
                            echo "<div id=\"table-week\" class=\"table\">
                                    No rows returned
                                    </div>";
                        }
                        else
                            {
                                while($row=mysqli_fetch_row($query))
                                {
                                    echo "
                                    <div id=\"table-week\" class=\"table\">
                                        <div>
                                            $row[1]
                                        </div>";
                                        
                                        echo "
                                        <div>";  
                                        
                                            $week_id = $row[0];
                                        
                                            $linked = mysqli_query($conn,"SELECT r.recipe_name 
                                            FROM week_historic h
                                            JOIN recipe r on r.id = h.recipe_id 
                                            WHERE h.week_id = $week_id
                                            ");

                                            if (mysqli_num_rows($linked)!=0){

                                                $count_recipe=0;
                                                
                                                while($row2=mysqli_fetch_row($linked))
                                                {
                                                    $count_recipe++;
                                                    echo "<span class=\"large\">$count_recipe. $row2[0]</span>";
                                                }
                                                
                                            };

                                        
                                                
                                    echo "                
                                        </div>";    


                                    echo "
                                        <div> 
                                            <a href=\"delete_week.php?param=$row[0]\"><a href=\"delete_week.php?param=$row[0]\"><button type=\"button\">Supprimer</button></a> 
                                        </div>

                                    </div>
                                    </form> ";
                                }
                            }

            
                        ?>
                    </div>
            </div>

                </main>
        
        <?php $conn->close(); ?>
    </body>
</html>