        <!-- Header partagé -->   
        <?php include 'header.php' ?>

        <!-- Recettes -->
        <main id="recipes">
            <div id="add_recipe">
                <h2 class="title">Ajouter une nouvelle recette</h2>
                <form action="add_recipe.php" method="POST">
                    Nom de la recette: <input type="text" class="input" name="recipe_name"><br>
                    <br>Type de cuisine : <br>
                    <div class="select">
                        <select name="cuisine_name">
                            <?php
                            $query_cuisine_name = mysqli_query($conn,'SELECT id,cuisine_name FROM cuisine');

                            if (mysqli_num_rows($query_cuisine_name)==0)
                            {
                                echo "<div class=\"table\">
                                        No rows returned
                                        </div>";
                            }
                            else
                                {
                                    while($row=mysqli_fetch_row($query_cuisine_name))
                                    {
                                        echo "
                                            <option value=\"$row[0]\">$row[1]</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <br>
                    <br>Saison : <br>
                    <div class="select is-multiple">
                        <select name="season_id[]" multiple="multiple">
                            <?php
                            $query_season_name = mysqli_query($conn,'SELECT id,season_name FROM season');

                            if (mysqli_num_rows($query_season_name)==0)
                            {
                                echo "<div class=\"table\">
                                        No rows returned
                                        </div>";
                            }
                            else
                                {
                                    while($row=mysqli_fetch_row($query_season_name))
                                    {
                                        if ($row[1]=="all"){
                                            $season = "Toutes saisons";
                                        } else if (
                                            $row[1]=="winter"){
                                                $season = "Hiver";
                                        } else if (
                                            $row[1]=="spring"){
                                                $season = "Printemps";
                                        } else if (
                                            $row[1]=="summer"){
                                                $season = "Eté";
                                        } else if (
                                            $row[1]=="autumn"){
                                                $season = "Automne";
                                            }
                                        
                                        echo "<option value=\"$row[0]\">$season</option>";
                                    
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <br>
                    <br>Attributs : <br>
                    <div class="select is-multiple">
                        <select name="attribute_id[]" multiple="multiple">
                            <?php
                            $query_attribute_name = mysqli_query($conn,'SELECT id,attribute_name FROM attribute');

                            if (mysqli_num_rows($query_attribute_name)==0)
                            {
                                echo "<div class=\"table\">
                                        No rows returned
                                        </div>";
                            }
                            else
                                {
                                    while($row=mysqli_fetch_row($query_attribute_name))
                                    {
                                        echo "
                                            <option value=\"$row[0]\">$row[1]</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <br><br>
                    <input type="submit" value="Créer une nouvelle recette" class="button is-link">
                </form>
                <br><br>
            </div>

            <div id="view_recipes">
                <h2 class="title">Recettes existantes</h2>

                <div>
                    <div  id="table-recipe" class="table bold">
                        <div>Nom de la recette</div>
                        <div>Type de cuisine</div>
                        <div>Saison</div>
                        <div>Attributs</div>
                        <div>Modifier</div>
                        <div>Supprimer</div>
                    </div>

                    <?php
                        $query_recipes = mysqli_query($conn,'SELECT r.id, r.recipe_name, c.id, c.cuisine_name FROM recipe r left join cuisine c on c.id = r.cuisine_id WHERE active=1 order by c.id');

                        if (mysqli_num_rows($query_recipes)==0)
                        {
                            echo "<div id=\"table-recipe\" class=\"table\">
                                    Aucune recette créée
                                    </div>";
                        }
                        else {
                            
                            while($row=mysqli_fetch_row($query_recipes))
                                {
                                    $rec_id = $row[0];

                                    // Création des lignes
                                    echo "
                                        <form method=\"POST\" action=\"modify_recipe.php\">

                                        <div id=\"table-recipe\" class=\"table\">";

                                    // Impression du nom de la recette + champ caché pour modifier le nom de la recette
                                    echo "
                                            <div>
                                                <span id= \"visible_a_$rec_id\">
                                                    $row[1]
                                                </span>
                                                <span class=\"invisible\" id= \"invisible_a_$row[0]\"> 
                                                    <input type=\"text\" name=\"recipe_name\" value=\"$row[1]\">
                                                </span>
                                            </div>";

                                    // Impression du type de cuisine + champ caché pour changer le type de cuisine
                                    echo "
                                            <div>
                                                <span id= \"visible_b_$rec_id\">";

                                                    if ($row[3]!=''){
                                                        echo $row[3];
                                                    } else {
                                                        echo "Non définie";
                                                    };


                                    echo "
                                                </span>
                                                <span class=\"invisible\" id= \"invisible_b_$rec_id\"> 
                                                    <select name=\"cuisine_name\">";
                                                        
                                                        $query_cuisine_name = mysqli_query($conn,'SELECT id,cuisine_name FROM cuisine');

                                                        if (mysqli_num_rows($query_cuisine_name)==0)
                                                        {
                                                            echo "Aucun type disponible";
                                                        }
                                                        else
                                                            {
                                                                while($row2=mysqli_fetch_row($query_cuisine_name))
                                                                {
                                                                    $cui_id = $row2[0];
                                                                    
                                                                    echo "<option value=\"$row2[0]\" ";

                                                                    $query_cuisine_type = mysqli_query($conn,"SELECT 1 FROM recipe WHERE id = $rec_id and cuisine_id = $cui_id");
                                                                
                                                                if (mysqli_num_rows($query_cuisine_type)!=0) {
                                                                    echo "selected";
                                                                } 
                                                                    
                                                                    echo ">$row2[1]</option>";
                                                                }
                                                            }                                                
                                    echo "                
                                                </select>
                                            </span>
                                        </div>";
                                    
                                    // Impression des saisons + modification de saison invisible
                                    echo "
                                            <div>
                                                <span id=\"visible_c_$rec_id\">";

                                                    $linked_seasons = mysqli_query($conn,"SELECT s.season_name 
                                                    FROM season s
                                                    JOIN linked_season l on l.season_id = s.id 
                                                    WHERE l.recipe_id = $rec_id
                                                    ");

                                                    if (mysqli_num_rows($linked_seasons)==0){
                                                        echo "";
                                                    } else {

                                                        while($row3=mysqli_fetch_row($linked_seasons))
                                                        {
                                                            if ($row3[0]=="all"){
                                                                $season = "Toutes saisons";
                                                            } else if (
                                                                $row3[0]=="winter"){
                                                                    $season = "Hiver";
                                                            } else if (
                                                                $row3[0]=="spring"){
                                                                    $season = "Printemps";
                                                            } else if (
                                                                $row3[0]=="summer"){
                                                                    $season = "Eté";
                                                            } else if (
                                                                $row3[0]=="autumn"){
                                                                    $season = "Automne";
                                                                }
                                                            
                                                            echo $season.'<br>'; 
                                                        }
                                                    }

                                                    
                                        echo "
                                                </span>
                                                <span class=\"invisible\" id= \"invisible_c_$rec_id\"> 
                                                    <select name=\"season_id[]\" multiple=\"multiple\">";
                                        
                                                        $query_season_name = mysqli_query($conn,'SELECT id,season_name FROM season');

                                                        if (mysqli_num_rows($query_season_name)==0)
                                                        {
                                                            echo "<div class=\"table\">
                                                                    No rows returned
                                                                    </div>";
                                                        }
                                                        else
                                                            {
                                                                while($row4=mysqli_fetch_row($query_season_name))
                                                                {
                                                                    $sea_id = $row4[0];
                                                                    
                                                                    if ($row4[1]=="all"){
                                                                        $season = "Toutes saisons";
                                                                    } else if (
                                                                        $row4[1]=="winter"){
                                                                            $season = "Hiver";
                                                                    } else if (
                                                                        $row4[1]=="spring"){
                                                                            $season = "Printemps";
                                                                    } else if (
                                                                        $row4[1]=="summer"){
                                                                            $season = "Eté";
                                                                    } else if (
                                                                        $row4[1]=="autumn"){
                                                                            $season = "Automne";
                                                                        }
                                                                    
                                                                    echo "<option value=\"$row4[0]\" ";
                                                                    
                                                                    $query_season_checked = mysqli_query($conn,"SELECT 1 FROM linked_season WHERE recipe_id = $rec_id and season_id = $sea_id");
                                                                    
                                                                    if (mysqli_num_rows($query_season_checked)!=0) {
                                                                            echo "selected";
                                                                    }
                                                                
                                                                    echo ">$season</option>";
                                                                
                                                                }
                                                            }
                                                    
                                    echo "                
                                                    </select>
                                                </span>
                                            </div>";
                                    
                                    // Impression des attributs + modification des attributs invisibles
                                    echo "
                                            <div>
                                                <span id=\"visible_d_$rec_id\">";                        
                                            
                                                    $linked_attributes = mysqli_query($conn,"SELECT a.attribute_name 
                                                    FROM attribute a 
                                                    JOIN linked_attribute l on l.attribute_id = a.id 
                                                    WHERE l.recipe_id = $rec_id
                                                    ");

                                                    if (mysqli_num_rows($linked_attributes)!=0){
                                                        
                                                        while($row5=mysqli_fetch_row($linked_attributes))
                                                        {
                                                            echo "$row5[0] <br>";
                                                        }
                                                        
                                                    }

                                    echo "
                                                </span>
                                                <span class=\"invisible\" id= \"invisible_d_$rec_id\"> 
                                                    <select name=\"attribute_id[]\" multiple=\"multiple\">";

                                                    $query_attribute_name = mysqli_query($conn,'SELECT id,attribute_name FROM attribute');

                                                    if (mysqli_num_rows($query_attribute_name)==0)
                                                    {
                                                        echo "Aucun attribut";
                                                    }
                                                    else
                                                        {
                                                            while($row6=mysqli_fetch_row($query_attribute_name))
                                                            {
                                                                $attr_id = $row6[0];

                                                                echo "<option value=\"$row6[0]\" ";
                                                                
                                                                    $query_attribute_checked = mysqli_query($conn,"SELECT 1 FROM linked_attribute WHERE recipe_id = $rec_id and attribute_id = $attr_id");
                                                                    
                                                                    if (mysqli_num_rows($query_attribute_checked)!=0) {
                                                                        echo "selected";
                                                                    } 
                                                            
                                                                echo ">$row6[1]</option>";
                                                            }
                                                        }
                                                    
                                        echo "                
                                                    </select>
                                                </span>
                                            </div>";

                                    echo "
                                            <div> 
                                                <span id= \"visible_e_$rec_id\"> 
                                                    <a><button type=\"button\" onclick=\"modify($rec_id)\">Modifier</button></a>
                                                </span>
                                                <span class=\"invisible\"> 
                                                    <input type=\"number\" name=\"recipe_id\" value =\"$rec_id\">
                                                </span>
                                                <span class=\"invisible\" id= \"invisible_e_$rec_id\"> 
                                                    <a><button type=\"submit\">Valider la modification</button></a>
                                                </span>
                                            </div>
                    
                                        <div> 
                                            <a href=\"delete_recipe.php?param=$row[0]\"><button type=\"button\">Supprimer</button></a> 
                                        </div>
                                    </div> 
                                    </form>";
                                }
                            }
                    ?>      

                </div>
            </div>
        </main>
        

        <!-- Footer partagé -->   
        <?php include 'footer.php' ?>