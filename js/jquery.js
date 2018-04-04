$(document).ready(function() {
    var lieu;

    $('#map').on('click','path',function(e){
      x = e.pageX;
      y = e.pageY - 180;
      console.log(e.pageY);
      lieu = $(this).attr('id');
      $('#dep').css('left', x)
      $('#dep').css('top', y)
      $('#dep').text(lieu);
    })

    function listMonuments(lieu, epoque, categorie, type, recherche) {
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
            xmlhttp.open("GET","getListe.php?lieu="+lieu+"&epoque="+epoque+"&categorie="+categorie+"&type="+type+"&recherche="+recherche,true);
            xmlhttp.send();
        }

    // 1 => prehistoire
    // 2 => protohistoire
    // 3 => romain
});
