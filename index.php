<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" async></script>
    <script src="js/ajax.js" async></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/map.css">
    <title>Monuments d'ici et d'ailleurs</title>
</head>
<body>
    <header>
        <h1>Monuments d'ici et d'ailleurs</h1>
    </header>

    <main>
        <div id="select">

            <div id="map">
            <?php 
            include "css/dep/map.svg";
            ?>
            </div>

                <form action=""></form>
                <!-- Barre de recherche -->
                    <input type="search" name="search" id="">
                <!-- Carte France -->
                <!-- Catégories -->
                    <input type="button" name="search" id="">
        </div>
        <div id = "listMonuments">
            <!-- Liste des monuments issus de la recherche -->
        </div>

        

    </main>

</body>
</html>