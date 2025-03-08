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

        <!-- Type de cuisine -->
        <main id="cuisine_type">
            <div id="add_cuisine">
                <h2>Ajouter un nouveau type de cuisine</h2>
                <form method="POST" action="add_cuisine.php">
                    Type de cuisine : <input type="text" name="cuisine_name"><br>
                    <input type="submit">
                </form>
            </div>

            <div id="view_cuisine">
                <h2>Types de cuisine existants</h2>

                <div>
                    <div id="table-cuisine" class="table bold">
                        <div>Type de cuisine</div>
                        <div>Modifier</div>
                        <div>Supprimer</div>
                    </div>
                    <?php
                        $query_get_cuisine = mysqli_query($conn,'SELECT id, cuisine_name FROM cuisine');

                        if (mysqli_num_rows($query_get_cuisine)==0)
                        {
                            echo "<div class=\"table\">
                                    No rows returned
                                    </div>";
                        }
                        else
                        {
                            while($row=mysqli_fetch_row($query_get_cuisine))
                                {
                                    echo "
                                    <form method=\"POST\" action=\"modify_cuisine.php\">
                                        
                                    <div id=\"table-cuisine\" class=\"table\">
                                        <div>
                                            <span id= \"visible_a_$row[0]\">
                                                $row[1]
                                            </span>
                                            <span class=\"invisible\" id= \"invisible_a_$row[0]\"> 
                                                <input type=\"text\" name=\"cuisine_name\" value=\"$row[1]\">
                                            </span>
                                        </div>
                                        <div> 
                                            <span id= \"visible_b_$row[0]\"> 
                                                <button type=\"button\" onclick=\"modify($row[0])\">Modifier</button> 
                                            </span>
                                            <span class=\"invisible\"> 
                                                <input type=\"number\" name=\"cuisine_id\" value =\"$row[0]\">
                                            </span>
                                            <span class=\"invisible\" id= \"invisible_b_$row[0]\"> 
                                                <input type=\"submit\" value=\"Valider la modification\">
                                            </span>
                                        </div>
                    
                                        <div> 
                                            <a href=\"delete_cuisine.php?param=$row[0]\"><button type=\"button\">Supprimer</button></a> 
                                        </div>
                                    </div>
                                    </form> ";
                                }
                                
                        }
                        
                        ?>
            </div>

        </main>

    
        
        <?php $conn->close(); ?>
    </body>
</html>