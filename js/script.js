
// function retourFrance() {
//     $('#map').load('img/map.svg')
// }

function showMap(lieu) {

    switch (lieu) {

        case "Bretagne":
            $('#map').load('img/dep/bretagne.svg')
            $('#dep').text('Bretagne')
            break;
        case "paysLoire":
            $('#map').load('img/dep/payloire.svg')
            $('#dep').text('Pays de la Loire')
            break;
        case "IleDeFrance":
            $('#map').load('img/dep/iledef.svg')
            $('#dep').text('Ile de France')
            break;
        case "Provence":
            $('#map').load('img/dep/provence.svg')
            $('#dep').text('Provence-Alpes-Côte d\'Azur')
            break;
        case "Corse":
            $('#map').load('img/dep/corse.svg')
            $('#dep').css('left', '40%')
            $('#dep').text('Corse')
            break;
        case "Normandie":
            $('#map').load('img/dep/normandie.svg')
            $('#dep').text('Normandie')
            break;
        case "HautsDeFrance":
            $('#map').load('img/dep/hautdef.svg')
            $('#dep').text('Hauts-de-France')
            break;
        case "GrandEst":
            $('#map').load('img/dep/grandest.svg')
            $('#dep').text('Grand Est')
            break;
        case "Occitanie":
            $('#map').load('img/dep/occitanie.svg')
            $('#dep').text('Occitanie')
            break;
        case "Auvergne":
            $('#map').load('img/dep/auvergne.svg')
            $('#dep').text('Auvergne-Rhône-Alpes')
            break;
        case "ValDeLoire":
            $('#map').load('img/dep/centre.svg')
            $('#dep').css('left', '60%')
            $('#dep').text('Centre-Val de Loire')
            break;
        case "nouvelleAquitaine":
            $('#map').load('img/dep/nouvelleaqui.svg')
            $('#dep').css('top', '75%')
            $('#dep').css('left', '60%')
            $('#dep').text('Nouvelle Aquitaine')
            break;
        case "Bourgogne":
            $('#map').load('img/dep/bourgogne.svg')
            $('#dep').text('Bourgogne-Franche-Comté')
            break;
        case "France":
            $('#map').load('img/map.svg')
            $('#dep').text('')
            break;

    }
}