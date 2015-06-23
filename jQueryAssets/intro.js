var map;
var service;
var infowindow;

function initialize(lat,lng) {

  var pyrmont = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));

  map = new google.maps.Map(document.getElementById('intro_loca_map'), {
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      center: pyrmont,
      zoom: 15
    });

  var request = {
    location: pyrmont,
    radius: '500',
    query: 'restaurant'
  };
 var marker = new google.maps.Marker({
      position: pyrmont,
      map: map,
      title: 'Pop up!'});
 var populationOptions = {
      strokeColor: '#FF0000',
      strokeOpacity: 0.5,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.25,
      map: map,
      center: pyrmont,
      radius: 300
    };
	cityCircle = new google.maps.Circle(populationOptions);
  service = new google.maps.places.PlacesService(map);
  service.textSearch(request, callback);
}

function callback(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      var place = results[i];
      createMarker(results[i]);
    }
  }
}
