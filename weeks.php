        <!-- Header partagé -->   
        <?php include 'header.php' ?>

        <?php 
            // Get the list of attributes     
            $query_all_attributes = mysqli_query($conn,'SELECT id,max_number FROM attribute');
            
            if (mysqli_num_rows($query_all_attributes)!=0){

                $attributes_to_use =  array();

                while($row5=mysqli_fetch_row($query_all_attributes))
                    {
                        $attributes_to_use[] = [$row5[0],$row5[1],0];
                    }

            };
        ?>
        <script type="text/javascript">
            var getAllAttributes = <?php echo json_encode($attributes_to_use, JSON_NUMERIC_CHECK); ?>;
        </script> 

        <!-- Semaines  -->
        <main id="weeks">
            <div id="create_week">
                <h2 class="title">Créer une nouvelle semaine</h2>
                <form method="POST" action="create_modify_row.php?action=create&table=week" onsubmit="return validate_week_form()">
                    Nombre de jours : <input type="number" class="input" id="meal_number" name="meal_number"><br><br>
                    Date: <input type="date" class="input" id="meal_date" name="date"><br>
                    <br><br>

                    Choisir les recettes <span class="red">(en rouge les recettes utilisées sur la semaine précédente)</span> : <br><br>
                    
                    <div id="choose_recipes" class="table-flex">
                        <?php
                        $query_cuisine = mysqli_query($conn,'SELECT id, cuisine_name FROM cuisine');

                        if (mysqli_num_rows($query_cuisine)==0)
                        {
                            echo "<div>
                                    No rows returned
                                  </div>";
                        }
                        else {
                                while($row=mysqli_fetch_row($query_cuisine))
                                {
                                    $cuisine_id = $row[0];
                                    $query_recipes = mysqli_query($conn,
                                                    "SELECT r.id, r.recipe_name 
                                                     FROM recipe r 
                                                     WHERE r.cuisine_id = '$cuisine_id' and active = 1");

                                    if (mysqli_num_rows($query_recipes)==0)
                                    {
                                        continue;
                                    }
                                    else
                                        {
                                        // On récupère sur la première ligne tous les types de recette
                                        echo "<div>";
                                            echo "<div class=\"cell-head\"> $row[1] </div>";
                                    
                                            // On récupère sur les lignes suivantes toutes les recettes qui correspondent à ce type de cuisine
                                            echo "<div class=\"cell-body\">";
                                           
                                            while($row2=mysqli_fetch_row($query_recipes))
                                            {
                                                $query_last_week = mysqli_query($conn,"SELECT 1 FROM week w join week_historic h on h.week_id = w.id where w.id = (select max(id) from week) and recipe_id = '$row2[0]'");

                                                echo "<input type=\"checkbox\" name=\"choosen_recipe[]\" value=\"$row2[0]\" ";

                                                if (mysqli_num_rows($query_last_week)!=0){
                                                    echo "class=\"red\" ";
                                                };
                                                
                                                echo " />
                                                    <span ";

                                                if (mysqli_num_rows($query_last_week)!=0){
                                                    echo "class=\"red\"";
                                                };

                                                echo ">$row2[1]</span>";

                                                // Information about the seasons
                                                $linked_seasons = mysqli_query($conn,"SELECT l.season_id
                                                    FROM linked_season l 
                                                    WHERE l.recipe_id = $row2[0]");

                                                    if (mysqli_num_rows($linked_seasons)!=0){

                                                        echo "<select class=\"invisible\">";

                                                            while($row3=mysqli_fetch_row($linked_seasons))
                                                            {
                                                                echo "<option name=\"season_$row2[0]\" value=\"$row3[0]\"></option>";
                                                            }

                                                        echo "</select>";

                                                    };
                                                
                                                // Information about the attributes
                                                $linked_attributes = mysqli_query($conn,"SELECT l.attribute_id
                                                    FROM linked_attribute l
                                                    WHERE l.recipe_id = $row2[0]");

                                                if (mysqli_num_rows($linked_attributes)!=0){

                                                    echo "<select class=\"invisible\">";

                                                        while($row4=mysqli_fetch_row($linked_attributes))
                                                        {
                                                            echo "<option name=\"attribute_$row2[0]\" value=\"$row4[0]\"></option>";
                                                        }

                                                    echo "</select>";

                                                };
                                                
                                                echo "<br>";

                                            }
                                            echo "</div>";
                                        }
                                        echo "</div>";
                                    }
                            }
                        ?>
                    
                    </div>
                    
                    <br><br>
                    <a class="button is-link" onclick="choose_recipe()">Choisir automatiquement les recettes</a>  
                    <input type="submit" value="Valider la semaine" class="button is-link">
                    <span class="invisible red" id="missing_recipes">Pas assez de recettes sélectionnées</span>

                </form>
                </div>
                <br><br><br>
            </div>
            
            <!-- Previous weeks' plan -->
            <div id="view_past_weeks">
                <h2 class="title">Menus des semaines passées</h2>
                <div>
                    <div id="table-week" class="table bold">
                        <div>Semaine</div>
                        <div>Recettes</div>
                        <div>Supprimer</div>
                    </div>
                    <?php
                        $query = mysqli_query($conn,"SELECT w.id, w.date FROM week w order by w.date desc");

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
                                            <a href=\"delete_row.php?id=$row[0]&table=week\"><button type=\"button\">Supprimer</button></a> 
                                        </div>

                                    </div>
                                    </form> ";
                                }
                            }

            
                        ?>
                    </div>
            </div>

        </main>

        <!-- Footer partagé -->   
        <?php include 'footer.php' ?>
        
        