function findingAddress(address, map) {
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode({ 'address': address }, result = function (results, status) {
		if(status == google.maps.GeocoderStatus.OK) {
			position = results[0].geometry.location;
			var markerSettings = {
				position: position,
				map: map,
				txt: "Tournament location"
			}
			var marker = new google.maps.Marker(markerSettings);
			google.maps.event.addListener(marker, "click", function() {
				var ballon = new google.maps.InfoWindow();
				ballon.setContent(marker.txt);
				ballon.open(map, marker);
			});
			google.maps.event.trigger(marker, 'click');
			map.setCenter(position);
			return true;
		} else {
			return false;
		}
	});
	return result;
}

function initMap(tournamentPlace) {
	var mapSettings = {
		zoom: 14,
		center: new google.maps.LatLng(52.405416666667, 16.9254722222222222),
		mapTypeId: google.maps.MapTypeId.TERRAIN
	};
	var map = new google.maps.Map(document.getElementById("map"), mapSettings);
	findingAddress(tournamentPlace, map);
}