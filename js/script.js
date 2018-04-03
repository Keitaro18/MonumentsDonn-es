var chrono = document.getElementById('chrono');

// window.onload = function() {affichSize();};
window.addEventListener("resize", function() {affichSize();});

function affichSize() {
  var phone = window.matchMedia( "(max-width: 780px)" );
  if (window.matchMedia( "(max-width: 780px)" ).matches) {
    // chrono.innerHTML = "<?php include_once 'img/chronoMobile.svg'; ?>";
    chrono.load('img/chronoMobile.svg');
    //  .load marche très bien en soi mais aucun css n'est appliqué
  } else {
    // chrono.innerHTML = "<?php include_once 'img/chronoScreen.svg'; ?>";
    chrono.load('img/chronoScreen.svg');
  }
}
