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
    private $conn;

    public function queryEpoque() {
      if ($this->epoque <> '') {
              $this->conn = connexion();
              $epoques = explode (';', $this->epoque);
              // On veut à peu près 15 résultats au total, or on passe plusieurs requêtes qui se cumulent
              $limit = round(15 / count($epoques));
              foreach ($epoques as $value){
                    $requete = $this->conn->prepare('SELECT Commune, Appellation, Siecle FROM
                          (SELECT Monuments.Appellation AS Appellation,
                                  Monuments.DetailSiecle AS Siecle,
                                  Codes.Commune AS Commune,
                                  Monuments.INSEE,
                                  Codes.CodePostal
                              FROM Monuments INNER JOIN Codes
                                ON Monuments.INSEE = Codes.INSEE
                                AND Monuments.CodeEpoque = ' . $value . '
                              LIMIT ' . $limit . ' OFFSET ' . ($this->offset * 15)  .
                          ') AS t');
                  $this->afficheResultat($requete);
              } // foreach
          // $conn=null;
      }
    } // queryEpoque()

    public function query() {
      $this->conn = connexion();
      if (strlen ($this->lieu) < 4){
          $requete = $this->conn->prepare('SELECT DISTINCT INSEE, Commune, Appellation, Detail FROM
                (SELECT Monuments.Appellation AS Appellation,
                        Monuments.DetailSiecle AS Detail,
                        Codes.Commune AS Commune,
                        Monuments.INSEE AS INSEE,
                        Codes.CodePostal AS Code
                    FROM Monuments INNER JOIN Codes
                        ON Monuments.INSEE = Codes.INSEE
                        AND Monuments.INSEE REGEXP "^'. $this->lieu . '|; '. $this->lieu . '"
                LIMIT 15 OFFSET ' . ($this->offset * 15) .
                ') AS t');

      }else{
          $requete = $this->conn->prepare('SELECT Appellation, Commune, Detail FROM
                (SELECT Monuments.Appellation AS Appellation,
                        Monuments.DetailSiecle AS Detail,
                        Codes.Commune AS Commune,
                        Monuments.INSEE AS INSEE,
                        Regions.Region AS Region,
                        Codes.INSEE AS Code
                    FROM Monuments
                    INNER JOIN Regions
                        ON LEFT(Monuments.INSEE, 2) = Regions.CodeDpt
                        AND Regions.Region = "' . $this->lieu . '"
                    INNER JOIN Codes
                        ON Monuments.INSEE = Codes.INSEE
                  LIMIT 15 OFFSET ' . ($this->offset * 15) .
                ') AS t');
      }
      $this->afficheResultat($requete);
      $conn=null;
    } // query()

    // fonction appelée par d'autres fonctions dans la classe, donc privée
    // gère l'affichage de la liste de résultats
    private function afficheResultat($requete) {
      $requete->execute();
      $requete->setFetchMode(PDO::FETCH_ASSOC);
      while($ligne = $requete->fetch()) {
          echo '<div class="ligne">';
          echo '<p>' . $ligne['Commune'] . '</p>';
          echo '<p>' . substr($ligne['Appellation'], 0, 70) . '</p>';
          echo '<p>' . substr($ligne['Siecle'], 0, 30) . '</p>';
          echo '</div>';
      }
      echo '<input type="button" class="navig" id="precedent" value="Précédent">';
      echo '<input type="button" class="navig" id="suivant" value="Suivant">';
    } // afficheResultat()

  } // class Recherche

// connexion() contient tout ce qui est fixe dans l'ouverture de la requête base de donnée
function connexion() {
  // Comme on require un fichier depuis un fichier appelé par ajax depuis un autre répertoire etc
  // Bref comme c'est compliqué et que le chemin n'est jamais le bon
  // Avec dirname(__FILE__) on part du dossier dans lequel est ce fichier-ci pour chercher nos required
    require_once dirname(__FILE__) . '/param.php';
    require_once dirname(__FILE__) . '/connectionDB.php';

    try
    {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
            die('Erreur : ' . $e->getMessage());
    }
    // La connexion bien ouverte, on la renvoie à l'appeleur, ici dans la classe
    return $conn;
}

$rechercheClic = new Recherche;
$rechercheClic->lieu = $_GET['lieu'];
$rechercheClic->categorie = $_GET['categorie'];
$rechercheClic->epoque = $_GET['epoque'];
$rechercheClic->offset = $_GET['offset'];
// $rechercheClic->query();
$rechercheClic->queryEpoque();

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
