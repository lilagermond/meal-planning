        <!-- Header partagé -->   
        <?php include 'header.php' ?>


        <!-- Semaines  -->
        <main id="weeks">
            <div id="create_week">
                <h2 class="title">Créer une nouvelle semaine</h2>
                <form action="add_week.php" onsubmit="return validate_week_form()">
                    Nombre de jours : <input type="number" class="input" id="meal_number" name="meal_number"><br><br>
                    Date: <input type="date" class="input" name="date"><br>
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
                        else
                            {
                                while($row=mysqli_fetch_row($query_cuisine))
                                {
                                    $cuisine_id = $row[0];
                                    $query_recipes = mysqli_query($conn,"SELECT r.id, r.recipe_name FROM recipe r where r.cuisine_id = '$cuisine_id'");

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
                                            $query_last_week = mysqli_query($conn,"SELECT recipe_id FROM week w join week_historic h on h.week_id = w.id where w.id = (select max(id) from week)");

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

                                                echo ">$row2[1]</span><br>";

                                            }
                                            echo "</div>";
                                        }
                                        echo "</div>";
                                    }
                                echo "</div>";
                            }
                        ?>
                    </div>
                    
                    <a class="button is-link" onclick="choose_recipe()">Choisir automatiquement les recettes</a>  
                    <button class="button is-link">Valider la semaine</button>
                    <span class="invisible red" id="missing_recipes">Pas assez de recettes sélectionnées</span>
                </form>

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
                                            <a href=\"delete_week.php?param=$row[0]\"><a href=\"delete_week.php?param=$row[0]\"><button type=\"button\" class=\"button is-light is-small\" >Supprimer</button></a> 
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
        
        