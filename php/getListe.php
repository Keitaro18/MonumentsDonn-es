<?php

// echo($_POST['search']);
// if (empty($_POST['lieu'])) {$_POST['lieu']='';}
// if (empty($_POST['categorie'])) {$_POST['categorie']='';}
// if (empty($_POST['type'])) {$_POST['type']='';}

  class Recherche {
    public $epoque; // soit clic sur frise chrono, soit champ de recherche (si "par époque" coché)
    public $categorie; // bouton cliqué : église, château, site archéologique...
    public $lieu; //$_POST['lieu']; // région ou département cliqué sur la carte
    public $search;
    private $offset;
    private $conn;
    private $type;

    public function setValues() {
      $this->offset = $_GET['offset'];
      $this->type = $_GET['type'];
      $this->lieu = $_GET['lieu'];
      $this->categorie = $_GET['categorie'];
      $this->epoque = $_GET['epoque'];
      $this->search = $_GET['recherche'];
    }
    public function queryEpoqueCarte() {
        $this->setValues();
            $this->conn = connexion();
            $epoques = str_replace (';','', $this->epoque);
            if (strlen ($this->lieu) < 4) { // clic sur département
                  $requete = $this->conn->prepare('SELECT DISTINCT INSEE, Commune, Appellation, Siecle, IdMon FROM
                          (SELECT Monuments.Appellation AS Appellation,
                                  Monuments.DetailSiecle AS Siecle,
                                  Codes.Commune AS Commune,
                                  Monuments.INSEE AS INSEE,
                                  Codes.CodePostal AS Code,
                                  Monuments.IdMon AS IdMon
                              FROM Monuments INNER JOIN Codes
                                  ON Monuments.INSEE = Codes.INSEE
                                  AND Monuments.CodeEpoque REGEXP "[' . $epoques . ']"
                                  AND Monuments.INSEE REGEXP "^'. $this->lieu . '"
                          LIMIT 15 OFFSET ' . ($this->offset * 15) .
                          ') AS t');
                  $this->afficheResultat($requete);
            } else { // clic sur région
                  $requete = $this->conn->prepare('SELECT Commune, Dpt, Appellation, Siecle, IdMon FROM
                        (SELECT Monuments.Appellation AS Appellation,
                                Monuments.DetailSiecle AS Siecle,
                                Codes.Commune AS Commune,
                                Regions.Dpt AS Dpt,
                                Monuments.INSEE AS INSEE,
                                Codes.CodePostal,
                                Monuments.IdMon AS IdMon
                            FROM Monuments
                              INNER JOIN Codes
                                  ON Monuments.INSEE = Codes.INSEE
                                  AND Monuments.CodeEpoque REGEXP "[' . $epoques . ']"
                              INNER JOIN Regions
                                  ON LEFT(Monuments.INSEE, 2) = Regions.CodeDpt
                                  AND Regions.Region = "' . $this->lieu . '"
                            LIMIT 15 OFFSET ' . ($this->offset * 15)  .
                        ') AS t');
                        // $this->afficheDebug('SELECT Commune, Dpt, Appellation, Siecle, IdMon FROM
                        //       (SELECT Monuments.Appellation AS Appellation,
                        //               Monuments.DetailSiecle AS Siecle,
                        //               Codes.Commune AS Commune,
                        //               Regions.Dpt AS Dpt,
                        //               Monuments.INSEE AS INSEE,
                        //               Codes.CodePostal,
                        //               Monuments.IdMon AS IdMon
                        //           FROM Monuments
                        //             INNER JOIN Codes
                        //                 ON Monuments.INSEE = Codes.INSEE
                        //                 AND Monuments.CodeEpoque REGEXP "[' . $epoques . ']"
                        //             INNER JOIN Regions
                        //                 ON LEFT(Monuments.INSEE, 2) = Regions.CodeDpt
                        //                 AND Regions.Region = "' . $this->lieu . '"
                        //           LIMIT 15 OFFSET ' . ($this->offset * 15)  .
                        //       ') AS t');
                $this->afficheResultat($requete);
            } // clic sur région
    } // queryEpoqueCarte()

    public function queryEpoque() {
            $this->conn = connexion();
            // si plusieurs époques, on cherche les lignes correspondant indifféremment à chacune
            $epoques = str_replace (';','', $this->epoque);
                  $requete = $this->conn->prepare('SELECT Commune, Appellation, Siecle, IdMon FROM
                        (SELECT Monuments.Appellation AS Appellation,
                                Monuments.DetailSiecle AS Siecle,
                                Codes.Commune AS Commune,
                                Monuments.INSEE AS INSEE,
                                Codes.CodePostal,
                                Monuments.IdMon AS IdMon
                            FROM Monuments
                              INNER JOIN Codes
                                  ON Monuments.INSEE = Codes.INSEE
                                  AND Monuments.CodeEpoque REGEXP "[' . $epoques . ']"
                            LIMIT 15 OFFSET ' . ($this->offset * 15)  .
                        ') AS t');
              $this->afficheResultat($requete);
    } // queryEpoque()

    public function queryCarte() {
      $this->conn = connexion();
      if (strlen ($this->lieu) < 4) { // clic sur département
          $requete = $this->conn->prepare('SELECT DISTINCT INSEE, Commune, Appellation, Siecle, IdMon FROM
                (SELECT Monuments.Appellation AS Appellation,
                        Monuments.DetailSiecle AS Siecle,
                        Codes.Commune AS Commune,
                        Monuments.INSEE AS INSEE,
                        Codes.CodePostal AS Code,
                        Monuments.IdMon AS IdMon
                    FROM Monuments INNER JOIN Codes
                        ON Monuments.INSEE = Codes.INSEE
                        AND Monuments.INSEE REGEXP "^'. $this->lieu . '|; '. $this->lieu . '"
                LIMIT 15 OFFSET ' . ($this->offset * 15) .
                ') AS t');
      } else {
          $requete = $this->conn->prepare('SELECT Appellation, Commune, Siecle, IdMon FROM
                (SELECT Monuments.Appellation AS Appellation,
                        Monuments.DetailSiecle AS Siecle,
                        Codes.Commune AS Commune,
                        Regions.Dpt AS Dpt,
                        Monuments.INSEE AS INSEE,
                        Regions.Region AS Region,
                        Codes.INSEE AS Code,
                        Monuments.IdMon AS IdMon
                    FROM Monuments
                    INNER JOIN Regions
                        ON LEFT(Monuments.INSEE, 2) = Regions.CodeDpt
                        AND Regions.Region = "' . $this->lieu . '"
                    INNER JOIN Codes
                        ON Monuments.INSEE = Codes.INSEE
                  LIMIT 15 OFFSET ' . ($this->offset * 15) .
                ') AS t');
      } // clic sur région
      $this->afficheResultat($requete);
      $conn=null;
    } // query()

    // fonction appelée par d'autres fonctions dans la classe, donc privée
    // gère l'affichage de la liste de résultats
    private function afficheResultat($requete) {
      $requete->execute();
      $requete->setFetchMode(PDO::FETCH_ASSOC);
      $nbligne = 0;
      while($ligne = $requete->fetch()) {
          echo '<div class="ligne">';
          // selon la requête le département est renseigné ou non (utile ou non)
          if (isset($ligne['Dpt']))   $lieu = $ligne['Commune'] . ' ' . $ligne['Dpt'];
          else                        $lieu = $ligne['Commune'];
          echo '<p class="valeur">' . $lieu . '</p>';

          echo '<p class="valeur">' . substr($ligne['Appellation'], 0, 70) . '</p>';
          echo '<p class="valeur">' . substr($ligne['Siecle'], 0, 30) . '</p>';
          echo '<div id="info'. $ligne['IdMon'] . '">'. $ligne['IdMon'] . '</div>';
          echo '</div>';
          $nbligne++;
      }
      echo '<input type="button" class="navig" id="precedent" value="Précédent">';
      if ($nbligne == 15) echo '<input type="button" class="navig" id="suivant" value="Suivant">';
    } // afficheResultat()

    private function afficheDebug($query) {
      echo $query;
    }
  } // class Recherche

// connexion() contient tout ce qui est fixe dans l'ouverture de la requête base de donnée
function connexion() {
  // Comme on require un fichier depuis un fichier appelé par ajax depuis un autre répertoire etc
  // Bref comme c'est compliqué et que le chemin n'est jamais le bon
  // Avec dirname(__FILE__) on part du dossier dans lequel est ce fichier-ci pour chercher nos required
    require dirname(__FILE__) . '/param.php';
    require dirname(__FILE__) . '/connectionDB.php';

  // La connexion bien ouverte, on la renvoie à l'appeleur, ici dans la classe
    return $conn;
}

$recherche = new Recherche;
$recherche->setValues();

if ($_GET['type'] <> '') {
  switch ($_GET['type']) {
    case 0:
      $recherche->lieu = $_POST['lieu'];
      break;
    case 1:
      $recherche->epoque = $_POST['epoque'];
      break;
    case 2:
      $recherche->nom = $_POST['nom'];
      break;
  }
} else {
  if (($recherche->epoque <> '') && ($recherche->lieu <> '')) {
    $recherche->queryEpoqueCarte();
    // echo 'queryEpoqueCarte';
  } elseif ($recherche->lieu <> "") {
    $recherche->queryCarte();
    // echo 'queryCarte';
  } elseif (($recherche->epoque <> '') && ($recherche->lieu == '')) {
    $recherche->queryEpoque();
    // echo 'queryEpoque';
  }
}


 ?>
