<?php

// echo($_POST['search']);
// if (empty($_POST['lieu'])) {$_POST['lieu']='';}
// if (empty($_POST['categorie'])) {$_POST['categorie']='';}
// if (empty($_POST['type'])) {$_POST['type']='';}

  class Recherche {
    public $epoque;
    public $categorie; // bouton cliqué : église, château, site archéologique...
    public $lieu; //$_POST['lieu']; // nom de ce qu'on clique
    public $nom;
    public $offset;

    public function query() {
      // require '/php/param.php';
      // require '/php/connexionDB.php';
      $servername = 'localhost';
      $database = 'monuments';
      $username = 'eole';
      $password = 'CorioMySQL&1';
      try
      {
          $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch (PDOException $e)
      {
              die('Erreur : ' . $e->getMessage());
      }

      $requete = $conn->prepare('SELECT Appellation, Commune, Detail FROM
                                    (SELECT Monuments.Appellation AS Appellation, Monuments.DetailSiecle AS Detail,
                                            CodesPostaux.Nom_commune AS Commune, Monuments.INSEE AS INSEE,
                                            CodesPostaux.Code_Postal AS Code
                                        FROM Monuments INNER JOIN CodesPostaux
                                            ON LEFT(Monuments.INSEE, 3) = LEFT(CodesPostaux.Code_Postal, 3)
                                            AND Monuments.INSEE REGEXP "^'. $this->lieu . '|; '. $this->lieu . '"
                                     LIMIT 15 OFFSET ' . ($this->offset * 15) .
                                    ') AS t');
      $requete->execute();
      $requete->setFetchMode(PDO::FETCH_ASSOC);
      while($ligne = $requete->fetch()) {
          echo '<div class="ligne">';
          echo '<p>' . substr($ligne['Appellation'], 0, 70) . '</p>';
          echo '<p>' . $ligne['Commune'] . '</p>';
          echo '<p>' . substr($ligne['Detail'], 0, 35) . '</p>';
          echo '</div>';
      }
      echo '<input type="button" id="suivant" value="Suivant">';
      $conn->null;
    }
  }

$rechercheClic = new Recherche;
$rechercheClic->lieu = $_GET['lieu'];
$rechercheClic->categorie = $_GET['categorie'];
$rechercheClic->epoque = $_GET['epoque'];
$rechercheClic->offset = $_GET['offset'];
$rechercheClic->query();

// $rechercheChamp = new Recherche;

// switch ($_GET['type']) {
//   case 0:
//     $rechercheChamp->lieu = $_POST['lieu'];
//     break;
//   case 1:
//     $rechercheChamp->epoque = $_POST['epoque'];
//     break;
//   case 2:
//     $rechercheChamp->nom = $_POST['nom'];
//     break;
// }

 ?>
