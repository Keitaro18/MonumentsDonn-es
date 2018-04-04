$(document).ready(function() {
    var niveau = 0;
    var lieu = '';
    var epoque = '';
    var categorie = '';
    var type = '';
    var recherche = '';

    $('aside').fadeIn(1000);

    $('#map').on('mouseover','path',function(e){
      x = e.pageX;
      y = e.pageY - 180;
      lieu = $(this).attr('id');
      $('#dep').text(lieu);
      $('#dep').css('left', x)
      $('#dep').css('top', y)
    })

    $('#map').on('click','path',function(e){
      $('#map path').css('fill', '#dfffff');
      lieu = $(this).attr('id');
      $(this).css('fill', '#c64c4e');
      if ($('#commune').is(':checked')) { $('#commune').prop('checked', false); }
      listMonuments(lieu, epoque, categorie, type, recherche);
    })

    $('#chronoFrise').on('mouseover','path',function(e){
      x = e.pageX;
      y = e.pageY;
      epoque = $(this).attr('id');
      $('#dep').text(epoque);
      $('#dep').css('left', x)
      $('#dep').css('top', y - 180)
    })

    $('#chronoFrise').on('click','path',function(e){
      epoque = $(this).attr('id');
      $(this).css('fill', '#7D9EA5');
      if ($('#epoque').is(':checked')) { $('#epoque').prop('checked', false); }
      listMonuments(lieu, epoque, categorie, type, recherche);
    })

    $('#friseCat').on('mouseover','path',function(e){
      x = e.pageX;
      y = e.pageY;
      categorie = $(this).attr('id');
      $('#dep').text(categorie);
      $('#dep').css('left', x)
      $('#dep').css('top', y - 180)
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
