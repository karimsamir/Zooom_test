var map = null;
var marker = null;
var infowindow = null;
var arr_markers = {};
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
}

function addMarker(container, category_id) {

//    console.log(container.find("input[name=latitude]").val());
//    console.log(container.find("input[name=longitude]").val());
    var lat = container.find("input[name=latitude]").val();
    var lng = container.find("input[name=longitude]").val();
    var title_container = container.find(".event_title_container").html();
    var title = container.find(".event_title").html();
    var event_dates = container.find(".event_dates").html();
    var country = container.find(".event_country").html();
//    var description = container.find("input[name=description]").val();

    var event_id = container.find("input[name=event_id]").val();
    var marker_id = "cat_" + category_id + "_marker_" + event_id;

    $(".infowindow").find(".event_title").html(title_container);
    $(".infowindow").find(".event_dates").html(event_dates);
    $(".infowindow").find(".event_country").html(country);

    infowindow.close();

//    console.warn($(".infowindow").html());
    var marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(lat, lng),
        title: title,
        custom_content: $(".infowindow_container").html(),
        marker_id: marker_id,
        category_id: category_id
    });

    //extend the bounds to include each marker's position
    bounds.extend(marker.position);

    google.maps.event.addListener(marker, 'click', function () {

        infowindow.setContent(marker.custom_content);
        infowindow.open(map, marker);
    });

    //now fit the map to the newly inclusive bounds
    map.fitBounds(bounds);



//    arr_markers.push(marker);
    arr_markers[marker_id] = marker;
    console.info(arr_markers);
}

