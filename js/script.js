function showMap(lieu) {

  switch (lieu) {

    case "Bretagne":
      $('#map').load('img/dep/bretagne.svg')
      // $('#dep').text('Bretagne')
      break;
    case "Pays-de-la-Loire":
      $('#map').load('img/dep/payloire.svg')
      // $('#dep').text('Pays de la Loire')
      break;
    case "Ile-de-France":
      $('#map').load('img/dep/iledef.svg')
      // $('#dep').text('Ile de France')
      break;
    case "Provence-Alpes-Cote-dAzur":
      $('#map').load('img/dep/provence.svg')
      // $('#dep').text('Provence-Alpes-Côte d\'Azur')
      break;
    case "Corse":
      $('#map').load('img/dep/corse.svg')
      // $('#dep').text('Corse')
      break;
    case "Normandie":
      $('#map').load('img/dep/normandie.svg')
      // $('#dep').text('Normandie')
      break;
    case "Hauts-de-France":
      $('#map').load('img/dep/hautdef.svg')
      // $('#dep').text('Hauts-de-France')
      break;
    case "Grand-Est":
      $('#map').load('img/dep/grandest.svg')
      // $('#dep').text('Grand Est')
      break;
    case "Occitanie":
      $('#map').load('img/dep/occitanie.svg')
      // $('#dep').text('Occitanie')
      break;
    case "Auvergne":
      $('#map').load('img/dep/auvergne.svg')
      // $('#dep').text('Auvergne-Rhône-Alpes')
      break;
    case "Centre-Val-de-Loire":
      $('#map').load('img/dep/centre.svg')
      // $('#dep').text('Centre-Val de Loire')
      break;
    case "Nouvelle-Aquitaine":
      $('#map').load('img/dep/nouvelleaqui.svg')
      // $('#dep').text('Nouvelle Aquitaine')
      break;
    case "Bourgogne-Franche-Comte":
      $('#map').load('img/dep/bourgogne.svg')
      // $('#dep').text('Bourgogne-Franche-Comté')
      break;
    case "France":
      $('#map').load('img/map.svg')
      // $('#dep').text('')
      break;

  }
}
