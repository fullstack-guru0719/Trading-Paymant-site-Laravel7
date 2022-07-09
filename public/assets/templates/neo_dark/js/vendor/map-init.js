
function initMap() {

    var mapsID = document.getElementById("maps");
    var dataLatitude = mapsID.getAttribute('data-latitude');
    var dataLongitude = mapsID.getAttribute('data-longitude');

  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(dataLatitude, dataLongitude),
      styles: [
          {
              elementType: 'labels',
              stylers: [{
                  visibility: 'on'
              }]
          },
          {
              elementType: 'geometry',
              stylers: [{
                  color: '#EDEDED'
              }]
          },
          {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{
                  color: '#998061'
              }]
          },
          {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{
                  color: '#c6e7a8'
              }]
          },
          {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{
                  color: '#F7F7F7'
              }]
          },
          {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{
                  color: '#F7F7F7'
              }]
          },
          {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{
                  color: '#ffdba5'
              }]
          },
          {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{
                  color: '#f9be7f'
              }]
          },
          {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{
                  color: '#9fcbfc'
              }]
          },
          {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{
                  color: '#9fcbfc'
              }]
          },
          {
              "featureType": "road",
              "elementType": "labels",
              "stylers": [
                  { "visibility": "on" }
              ]
          }
      ]
  });


}
