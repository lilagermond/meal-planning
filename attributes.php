        <!-- Header partagé -->   
        <?php include 'header.php' ?>

        <!-- Attributs -->
        <main id="attributes">
            <div id="add_attribute">
                <h2 class="title">Ajouter un nouvel attribut</h2>
                <form action="create_modify_row.php?action=create&table=attribute" method="POST">
                    Nom de l'attribut : <br>
                    <input type="text" class="input" name="attribute_name"><br><br>
                    Nombre max par semaine : <br>
                    <input type="number" class="input" name="max_number"><br>
                    <br>
                    <input type="submit" value="Créer un attribut" class="button is-link">
                </form>
                <br><br>
            </div>

            <div id="view_attribute">
                <h2 class="title">Types d'attributs existants</h2>
                <div>
                    <div id="table-attribute" class="table bold">
                        <div>Nom de l'attribut</div>
                        <div>Max par semaine</div>
                        <div>Modifier</div>
                        <div>Supprimer</div>
                    </div>
                    <?php
                        $query = mysqli_query($conn,'SELECT * FROM attribute');

                        if (mysqli_num_rows($query)==0)
                        {
                            echo "<div id=\"table-attribute\" class=\"table\">
                                    No rows returned
                                    </div>";
                        }
                        else
                            {
                                while($row=mysqli_fetch_row($query))
                                {
                                    echo "
                                    <form method=\"POST\" action=\"create_modify_row.php?action=modify&table=attribute\">    
                                    <div id=\"table-attribute\" class=\"table\">
                                        <div>
                                            <span id= \"visible_a_$row[0]\">
                                                $row[1]
                                            </span>
                                            <span class=\"invisible\" id= \"invisible_a_$row[0]\"> 
                                                <input type=\"text\" name=\"attribute_name\" value=\"$row[1]\">
                                            </span>
                                        </div>
                                        
                                        <div>
                                            <span id= \"visible_b_$row[0]\">
                                                $row[2]
                                            </span>
                                            <span class=\"invisible\" id= \"invisible_b_$row[0]\"> 
                                                <input class=\"small\" type=\"number\" name=\"max_number\" value=\"$row[2]\">
                                            </span>
                                        </div>

                                        <div> 
                                            <span id= \"visible_c_$row[0]\"> 
                                                <a><button type=\"button\" onclick=\"modify_table_row($row[0])\">Modifier</button></a> 
                                            </span>
                                            <span class=\"invisible\"> 
                                                <input type=\"number\" name=\"attribute_id\" value =\"$row[0]\">
                                            </span>
                                            <span class=\"invisible\" id= \"invisible_c_$row[0]\"> 
                                                <a><button type=\"submit\">Valider la modification</button></a>
                                            </span>
                                        </div>
                    
                                        <div> 
                                            <a href=\"delete_row.php?id=$row[0]&table=attribute\"><button type=\"button\">Supprimer</button></a> 
                                        </div>

                                    </div>
                                    </form> ";
                                }
                            }

            
                        ?>
                    </div>
            </div>
            </div>

        </main>


        <!-- Footer partagé -->   
        <?php include 'footer.php' ?>