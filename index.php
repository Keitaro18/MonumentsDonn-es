<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/ico" href="img/monu_hist.ico">
  <link rel="stylesheet" media="screen and (min-width: 781px)" href="css/screen.css">
  <link rel="stylesheet" media="screen and (max-width: 780px)" href="css/phone.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/map.css">
  <link rel="stylesheet" href="css/fonts.css">
  <link href="https://fonts.googleapis.com/css?family=Redressed" rel="stylesheet">
  <title>Monuments d'ici et d'hier</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" async></script>
  <script type="text/javascript" src="js/script.js" async></script>
</head>
<body>

  <header>
        <h1>Monuments d'ici et d'hier</h1>
        <?php include_once 'img/chrono.svg'; ?>
        <div id="legendes">
              <span id="pre">Prehistoire</span>
              <span id="proto">Proto <small>histoire</small></span>
              <span id="anti">Antiquité</span>
              <span id="m-age">Moyen-Age</span>
              <span id="temps">Temps modernes</span>
        </div>
        <?php include_once "img/friseCat.svg"; ?>
  </header>

   <aside id="select">
         <p id="dep"></p>
         <div id="map">
           <?php include "img/map.svg"; ?>
         </div>
         <form action="php/class.php" method="post" target="result">
           <input type="search" name="search" placeholder="Chercher" autofocus/>
           <input type="submit" name="go" value="Go!" />
           <div id="radio">
             <label for="commune">par commune</label>
             <input type="radio" name="type" value="commune" id="commune" checked>
             <label for="epoque">par époque</label>
             <input type="radio" name="type" value="époque" id="epoque">
             <label for="nom">par nom</label>
             <input type="radio" name="type" value="nom" id="nom">
           </div>
         </form>
    </aside>

    <main id="fenetre">
      <iframe name="result"></iframe>
      <div id = "listMonuments">
        <!-- Liste des monuments issus de la recherche -->
      </div>
    </main>

  <?php
      // $search = "<br>http://www.wikipedia.org/search-redirect.php?language=fr&search=" . $_POST['search'];
      // echo $search;
      // $search = "<br><br>http://commons.wikimedia.org/w/index.php?search=" . $_POST['search'];
      // echo $search;
  ?>
</main>

</body>
</html>
