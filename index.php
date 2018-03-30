<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" href="img/monu_hist.ico">
  <link rel="stylesheet" media="screen and (min-width: 781px)" href="css/screen.css">
  <link rel="stylesheet" media="screen and (max-width: 780px)" href="css/phone.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/map.css">
  <link rel="stylesheet" href="css/fonts.css">
  <link href="https://fonts.googleapis.com/css?family=Redressed" rel="stylesheet">
  <title>Monuments historiques</title>
</head>
<body>

 <main>
   <div id="select">

         <div class="map">
           <?php
              include "img/map.svg";
           ?>
         </div>

     </div>


  <div id="droite">

   <header>
     <h1>Monuments d'ici et d'hier</h1>
     <?php
       include "img/chronoScreen.svg";
       // include "img/chronoMobile.html";
      ?>
      <?php
        include "img/friseCat.svg";
        // include "img/chronoMobile.html";
       ?>
  </header>

  <div id="fenetre">
    <iframe name="result"></iframe>
    <div id = "listMonuments">
      <!-- Liste des monuments issus de la recherche -->
    </div>
  </div>

  </div>
  <?php
      // $search = "<br>http://www.wikipedia.org/search-redirect.php?language=fr&search=" . $_POST['search'];
      // echo $search;
      // $search = "<br><br>http://commons.wikimedia.org/w/index.php?search=" . $_POST['search'];
      // echo $search;
  ?>
</main>

</body>
</html>
