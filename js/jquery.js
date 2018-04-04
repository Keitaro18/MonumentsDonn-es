$(document).ready(function() {
    var niveau = 0;
    var lieu = '';
    var epoque = '';
    var nom_epoque = '';
    var categorie = '';
    var type = '';
    var recherche = '';
    var nom = '';

    $('aside').fadeIn(1000);

    $('#map').on('mouseover','path',function(e){
      // Ici on veut que l'étiquette "suive la souris", on récupère donc le paramètre "événement"
      x = e.pageX;
      y = e.pageY - $('#map').offset().top;
      // pageX et pageY nous donnent la position de la souris au moment du déclenchement de l'événement
      // donc au moment où la souris entre dans le champ du path
      // relativement à la page (alors que top est défini relativement à son containeur)
      // voir aussi clientX et screenX
      lieu = $(this).attr('id');
      if (lieu != 'fond') {
        $('#etiquet-var').text(lieu);
        $('#etiquet-var').css('left', x)
        $('#etiquet-var').css('top', y)
        $('#etiquet-var').fadeIn(100)
      }
      else {
        $('#etiquet-var').hide()
      }
    })

    // Plus besoin de l'étiquette en hover si on sort de la zone de la carte
    $('#map').on('mouseout','path',function(){
      $('#etiquet-var').hide()
    })

    $('#map').on('click','path',function(){
      $('#map path').css('fill', '#dfffff');
      lieu = $(this).attr('id');
      if (lieu != 'fond') {
        $('#etiquet-fix').text(lieu)
        $('#etiquet-fix').fadeIn(100)
        $(this).css('fill', '#c64c4e');
        if ($('#commune').is(':checked')) { $('#commune').prop('checked', false); }
        listMonuments(lieu, epoque, categorie, type, recherche);
      } // et si on clique sur le fond, la réinitialisation est prise en charge par la fonction "au clic" dans jquery.js
    })

    // $('#chronoFrise').on('mouseover','path',function(e){
    //   nom = $(this).attr('name');
    //   $('#etiquet-frises').text(nom)
    //   // $('#etiquet-frises').fadeIn(1000)
    // })

    $('#chronoFrise').on('click','path',function(e){
      // les époques peuvent se cumuler : si c'est le cas et qu'on coche plutôt qu'on ne décoche, on ajoute
      if ((epoque != '') && (!$(this).hasClass('coche') )) {
        // On affiche pour l'utilisateur le 'name', qui reprend le nom de l'époque
        // Et on range l'id correspondant à CodeEpoque dans la variable 'epoque', qui va servir à notre requête
        epoque += ';' + $(this).attr('id')
        nom_epoque += ' ; ' + $(this).attr('name')
      } // si on décoche, il faut retirer (c'est du pur javascript):
      else if ($(this).hasClass('coche')) {
        epoque = epoque.replace($(this).attr('id'), '');
        nom_epoque = nom_epoque.replace($(this).attr('name'), '');
        // on enlève les ';' solitaires avec un regex qui prend en compte : un ';' en début de chaîne, en fin de chaîne
        epoque = epoque.replace(/^;|;$/, '');
        nom_epoque = nom_epoque.replace(/^( ; )|( ; )$/, '');
        // on remplace également deux ';;' par un seul
        epoque = epoque.replace(/;;/, ';');
        nom_epoque = nom_epoque.replace(/( ;  ; )/, ' ; ');
      }
      else { // dernier cas : rien n'est rangé dans époque, on n'a pas besoin de ';', ni d'ajouter à l'existant
        epoque = $(this).attr('id')
        nom_epoque = $(this).attr('name')
      }
      console.log(epoque);
      // un clic => on ajoute la classe 'coche' à l'élément cliqué, devient bleu pour le visuel
      // deux clics => perd sa classe 'coche', reprend sa couleur d'origine
      $(this).toggleClass('coche');

      // Si le bouton radio 'epoque' est coché, on décoche (le clic sur la frise a précédence)
      if ($('#epoque').is(':checked')) {
        $('#epoque').prop('checked', false);
        $('#submit').prop('disabled', true);
      }
      listMonuments(lieu, epoque, categorie, type, recherche);
      $('#etiquet-frises').text(nom_epoque);
    })

    $('#friseCat').on('click','path',function(e){
      epoque += '<li>'+$(this).attr('id')+'</li>';
      $(this).css('fill', '#7D9EA5');
      if ($('#nom').is(':checked')) { $('#nom').prop('checked', false); }
      listMonuments(lieu, epoque, categorie, type, recherche);
      $('#frise').text(categorie);
    })

    function listMonuments(lieu, epoque, categorie, type, recherche) {
    //   $.ajax({    //create an ajax request to display.php
    //     type: "GET",
    //     url: "php/getListe.php?lieu="+lieu+"&epoque="+epoque+"&categorie="+categorie+"&type="+type+"&recherche="+recherche,
    //     dataType: "html",   //expect html to be returned
    //     success: function(response){
    //         $("#listMonuments").html(response);
    //     }
    // });

    if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $("#listMonuments").html(this.responseText);
            }
        };
        xmlhttp.open("GET","php/getListe.php?lieu="+lieu+"&epoque="+epoque+"&categorie="+categorie+"&type="+type+"&recherche="+recherche,true);
        xmlhttp.send();
  }

    // 1 => prehistoire
    // 2 => protohistoire
    // 3 => romain
});
