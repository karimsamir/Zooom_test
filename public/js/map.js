// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var map = null;
var marker = null;
var infowindow = null;
var geocoder = null;

function initMap(lat, lng, container_div) {

    var div_map = container_div.find(".map_canvas")[0];
    var latlng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));

    var mapOptions = {
        zoom: 13,
        center: latlng
    }

    map = new google.maps.Map(div_map, mapOptions);

    var input = container_div.find("input[name=location]")[0];

    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo('bounds', map);

    infowindow = new google.maps.InfoWindow();

    marker = new google.maps.Marker({
        position: latlng,
        map: map,
        anchorPoint: new google.maps.Point(0, -29),
        draggable: true
    });

    geocoder = new google.maps.Geocoder;


    autocomplete.addListener('place_changed', function () {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        
        placeChanged(place, container_div, false);
        

    });

    marker.addListener('dragend', function () {
        console.log("marker dragged");
        map.setZoom(8);
        map.setCenter(marker.getPosition());

        geocodeLatLng(marker.getPosition(), container_div);

    });
}

function geocodeLatLng(latlng, container_div) {

    geocoder.geocode({'location': latlng}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results[1]) {
//                map.setZoom(11);
//                var marker = new google.maps.Marker({
//                    position: latlng,
//                    map: map
//                });
//                infowindow.setContent(results[1].formatted_address);
//                infowindow.open(map, marker);
console.info(results[0]);
        placeChanged(results[0], container_div, true);
            } else {
                window.alert('No results found');
            }
        } else {
            window.alert('Geocoder failed due to: ' + status);
        }
    });
}

function placeChanged(place, container_div, marker_dragged) {
//    if (!place.geometry) {
//        window.alert("Autocomplete's returned place contains no geometry");
//        return;
//    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
    } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17);  // Why 17? Because it looks good.
    }

    var address = '';
    if (place.address_components) {
        address = [
            (place.address_components[0] && place.address_components[0].short_name || ''),
            (place.address_components[1] && place.address_components[1].short_name || ''),
            (place.address_components[2] && place.address_components[2].short_name || '')
        ].join(' ');
    }

    if (marker_dragged){
        console.log("formatted_address=="+place.formatted_address+":::");
        container_div.find("input[name=location]").val(place.formatted_address);
    }
    // set zip code in form
    var address_components = place.address_components;

console.debug(container_div);

    for (i = 0; i < address_components.length; i++) {
        if (address_components[i]["types"] == "postal_code") {
            container_div.find("input[name=zip]").val(address_components[i]["long_name"]);
        }
    }

    // change lat lng in form
    container_div.find("input[name=latitude]").val(place.geometry.location.lat());
    container_div.find("input[name=longitude]").val(place.geometry.location.lng());

    // show place marker
    var place_name = "";
    if (!marker_dragged){
       place_name = '<div><strong>' + place.name + '</strong><br>';
    }
    
    if(!marker_dragged){
        marker.setIcon(/** @type {google.maps.Icon} */({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
    }
    
    // change marker position
    marker.setPosition(place.geometry.location);
    // show marker
    marker.setVisible(true);
    // show info window
    infowindow.setContent(place_name + address);
    infowindow.open(map, marker);
}