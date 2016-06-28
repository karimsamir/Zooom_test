var map = null;
var marker = null;
var infowindow = null;
var arr_markers = [];
var arr_shown_markers = [];
var bounds;

function initMap() {

    var div_map = document.getElementById("map_canvas");

    var latlng = new google.maps.LatLng(40.265006, -99.995364);

    var mapOptions = {
        zoom: 4,
        center: latlng
    }

    map = new google.maps.Map(div_map, mapOptions);

    //create empty LatLngBounds object
    bounds = new google.maps.LatLngBounds();
    infowindow = new google.maps.InfoWindow();
    autoComplete();
}

function addMarker(container, category_id, show_marker) {

    var lat = container.find("input[name=latitude]").val();
    var lng = container.find("input[name=longitude]").val();
    var title_container = container.find(".event_title_container").html();
    var title = container.find(".event_title").html();
    var event_dates = container.find(".event_dates").html();
    var country = container.find(".event_country").html();

    var event_id = container.find("input[name=event_id]").val();
    var marker_id = "cat_" + category_id + "_marker_" + event_id;

    $(".infowindow").find(".event_title").html(title_container);
    $(".infowindow").find(".event_dates").html(event_dates);
    $(".infowindow").find(".event_country").html(country);

    infowindow.close();

    var marker = new google.maps.Marker({
//        map: map,
        position: new google.maps.LatLng(lat, lng),
        title: title,
        custom_content: $(".infowindow_container").html(),
        marker_id: marker_id,
        category_id: category_id
    });

    if (show_marker) {
//        arr_shown_markers[marker_id] = marker;
        arr_shown_markers.push(marker);
        marker.setMap(map);
        setInfowindowAndShow(marker);
    }
    //extend the bounds to include each marker's position
    bounds.extend(marker.position);

    google.maps.event.addListener(marker, 'click', function () {

        setInfowindowAndShow(marker);
    });

    //now fit the map to the newly inclusive bounds
    map.fitBounds(bounds);

    arr_markers.push(marker);

}

function setInfowindowAndShow(marker) {
    infowindow.setContent(marker.custom_content);
    infowindow.open(map, marker);
}

function filterMarkers(filters) {
    //remove all markers
    deleteMarkers();

    for (i = 0; i < filters.length; i++) {

        for (var j = 0; j < arr_shown_markers.length; j++) {
            if (filters[i] == arr_shown_markers[j].category_id) {
                arr_shown_markers[j].setMap(map);
            }
        }
    }
}

// Deletes all markers in the array.
function deleteMarkers() {
    for (var i = 0; i < arr_shown_markers.length; i++) {
        arr_shown_markers[i].setMap(null);
    }
}

function autoComplete() {

    var input = document.getElementById("autocomplete");

    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo('bounds', map);

    geocoder = new google.maps.Geocoder;

    autocomplete.addListener('place_changed', function () {
        
        deleteMarkers();
       
//        infowindow.close();
//        marker.setVisible(false);
        var place = autocomplete.getPlace();
        map.setCenter(place.geometry.location);
        map.setZoom(4);
        
//        bounds.extend(place.geometry.location);

        arr_shown_markers = [];
        
        for (var i = 0; i < arr_markers.length; i++) {
            
            if (google.maps.geometry.spherical.computeDistanceBetween
            (arr_markers[i].getPosition(), place.geometry.location) < 500000) {
                
                bounds.extend(arr_markers[i].getPosition());
                arr_markers[i].setMap(map);
                arr_shown_markers.push(arr_markers[i]);
                
            } else {
                arr_markers[i].setMap(null);
            }
        }
//        map.fitBounds(bounds);
    });
}
