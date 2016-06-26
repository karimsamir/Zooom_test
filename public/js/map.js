var map = null;
var marker = null;
var infowindow = null;

function initMap() {

    var div_map = document.getElementById("map_canvas");
    
    var latlng = new google.maps.LatLng(31.265006, 29.995364);

    var mapOptions = {
        zoom: 13,
        center: latlng
    }

    map = new google.maps.Map(div_map, mapOptions);

    
    infowindow = new google.maps.InfoWindow();

    marker = new google.maps.Marker({
        position: latlng,
        map: map,
        anchorPoint: new google.maps.Point(0, -29),
    });

}
