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

        <!-- Attributs -->
        <main id="attributes">
            <div id="add_attribute">
                <h2>Ajouter un nouvel attribut</h2>
                <form action="add_attribute.php" method="POST">
                    Nom de l'attribut : <input type="text" name="attribute_name"><br>
                    Nombre max par semaine : <input type="number" name="max_number"><br>
                    <input type="submit">
                </form>
            </div>

            <div id="view_attribute">
                <h2>Types d'attributs existants</h2>
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
                                    <form method=\"POST\" action=\"modify_attribute.php\">    
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
                                                <button type=\"button\" onclick=\"modify($row[0])\">Modifier</button> 
                                            </span>
                                            <span class=\"invisible\"> 
                                                <input type=\"number\" name=\"attribute_id\" value =\"$row[0]\">
                                            </span>
                                            <span class=\"invisible\" id= \"invisible_c_$row[0]\"> 
                                                <input type=\"submit\" value=\"Valider la modification\">
                                            </span>
                                        </div>
                    
                                        <div> 
                                            <a href=\"delete_attribute.php?param=$row[0]\"><button type=\"button\">Supprimer</button></a> 
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

        
        <?php $conn->close(); ?>
    </body>
</html>