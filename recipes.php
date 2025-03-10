        <!-- Header partagé -->   
        <?php include 'header.php' ?>

        <!-- Recettes -->
        <main id="recipes">

        <!-- Formulaire d'ajout d'une nouvelle recette -->
            <div id="add_recipe">
                <h2 class="title">Ajouter une nouvelle recette</h2>
                <form action="add_recipe.php" method="POST">
                    Nom de la recette: 
                        <input type="text" class="input" name="recipe_name"><br>
                    <br>Type de cuisine : <br>
                    <div class="select">
                        <?php get_select("cuisine_name",false,"create",0); ?>
                    </div>
                    <br>
                    <br>Saison : <br>
                    <div class="select is-multiple">
                        <?php get_select("season_id[]",true,"create",0); ?>
                    </div>
                    <br>
                    <br>Attributs : <br>
                    <div class="select is-multiple">
                        <?php get_select("attribute_id[]",true,"create",0); ?>
                    </div>
                    <br><br>
                    <input type="submit" value="Créer une nouvelle recette" class="button is-link">
                </form>
                <br><br>
            </div>

            <!-- Montrer la liste des recettes existantes pour pouvoir les consulter et les modifier -->
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

                                    // Création des entrées du tableau
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

                                    echo "      </span>
                                                <span class=\"invisible\" id= \"invisible_b_$rec_id\">  ";

                                                    get_select("cuisine_name",false,"modify","$rec_id");

                                    echo "
                                                </span>
                                            </div>";
                                    
                                    // Impression des saisons + modification de saison invisible
                                    echo "
                                            <div>
                                                <span id=\"visible_c_$rec_id\">";

                                                    $linked_seasons = mysqli_query($conn,"SELECT 
                                                        CASE WHEN s.season_name = 'all' THEN 'Toutes saisons'
                                                            WHEN s.season_name = 'winter' THEN 'Hiver'
                                                            WHEN s.season_name = 'spring' THEN 'Printemps'
                                                            WHEN s.season_name = 'summer' THEN 'Eté'
                                                            WHEN s.season_name = 'autumn' THEN 'Automne' END as season
                                                    FROM season s
                                                    JOIN linked_season l on l.season_id = s.id 
                                                    WHERE l.recipe_id = $rec_id");

                                                    if (mysqli_num_rows($linked_seasons)==0){
                                                        echo "";
                                                    } else {
                                                        while($row3=mysqli_fetch_row($linked_seasons))
                                                        {
                                                            echo $row3[0].'<br>'; 
                                                        }
                                                    };

                                                    
                                        echo "
                                                </span>
                                                <span class=\"invisible\" id= \"invisible_c_$rec_id\"> ";

                                                    get_select("season_id[]",true,"modify",$rec_id);
                                                        
                                    echo "                
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
                                                <span class=\"invisible\" id= \"invisible_d_$rec_id\"> ";
                                                
                                                    get_select("attribute_id[]",true,"modify",$rec_id);
                                    echo "
                                                </span>
                                            </div>";

                                    echo "
                                            <div> 
                                                <span id= \"visible_e_$rec_id\"> 
                                                    <a><button type=\"button\" onclick=\"modify_table_row($rec_id)\">Modifier</button></a>
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