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

            <div id="view_possibilities">
                <h2>Menus des semaines passées</h2>
                // Afficher les semaines passées
            </div>

        </main>
        
        <?php $conn->close(); ?>
    </body>
</html>