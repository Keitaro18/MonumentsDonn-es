<?php

class Info {
  public $IdMon;

  public function getInfo() {
      $this->conn = connexion();
      $requete = $this->conn->prepare('SELECT * FROM Info WHERE IdMon = "'. $info->IdMon . '"');
      $this->afficheResultat($requete);
      $conn=null;
    }

  // gère l'affichage des infos détaillées pour le monument sélectionné
  public function afficheResultat($requete) {
    $requete->execute();
    $requete->setFetchMode(PDO::FETCH_ASSOC);
    while($ligne = $requete->fetch()) {
        echo '<div class="ligne">';
        echo '<p>' . $ligne['DetailSiecle'] . '</p>';
        echo '</div>';
    }
  }
}

$info = new Info;
$info->IdMon = $_GET['id'];
// $info->getInfo();
$info->afficheResultat();

?>
