        <!-- Header partagé -->   
        <?php include 'header.php' ?>


        <!-- Semaines  -->
        <main id="weeks">

        <h2 class="title">Menus des semaines passées</h2>
                <div>
                    <div id="table-week" class="table bold">
                        <div>Semaine</div>
                        <div>Recettes</div>
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

                                    </div>
                                    </form> ";
                                }
                            }

            
                        ?>
                    </div>

        </main>
        
        <!-- Footer partagé -->   
        <?php include 'footer.php' ?>