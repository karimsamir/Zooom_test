var map = null;
var marker = null;
var infowindow = null;
var arr_markers = {};
var bounds;

function initMap() {

    var div_map = document.getElementById("map_canvas");

    var latlng = new google.maps.LatLng(31.265006, 29.995364);

    var mapOptions = {
        zoom: 13,
        center: latlng
    }

    map = new google.maps.Map(div_map, mapOptions);

    //create empty LatLngBounds object
    bounds = new google.maps.LatLngBounds();
    infowindow = new google.maps.InfoWindow();
}

function addMarker(container, category_id) {

    console.log(container.find("input[name=latitude]").val());
    var lat = container.find("input[name=latitude]").val();
    var lng = container.find("input[name=longitude]").val();
    var title = container.find(".event_title").html();
    var event_dates = container.find(".event_dates").html();
    var country = container.find(".event_country").html();
    var description = container.find("input[name=description]").val();

    var event_id = container.find("input[name=event_id]").val();
    var marker_id = "cat_" + category_id + "_marker_" + event_id;

    if ((marker_id in arr_markers)){
        
    }

    console.log("title==" + title + "::event_dates==" + event_dates + ":::country==" + country + ":::");
    $(".infowindow").find(".event_title").html(title);
    $(".infowindow").find(".event_dates").html(event_dates);
    $(".infowindow").find(".event_country").html(country);

//    console.warn($(".infowindow").html());
    var marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(lat, lng),
        title: title,
//        shadow: pinShadow,1
        custom_content: $(".infowindow_container").html(),
        list_content: $("#addressBox_template ul").html(),
        marker_id: marker_id,
        category_id: category_id
    });



//extend the bounds to include each marker's position
    bounds.extend(marker.position);

    google.maps.event.addListener(marker, 'click', function () {

        infowindow.setContent(marker.custom_content);
        infowindow.open(map, marker);
    });

console.log("marker.marker_id=="+marker.marker_id+"::marker.category_id=="+marker.category_id+":::");
//now fit the map to the newly inclusive bounds
    map.fitBounds(bounds);
    // change marker position
//    marker.setPosition(place.geometry.location);
    // show marker
//    marker.setVisible(true);


//    arr_markers.push(marker);
    arr_markers[marker_id] = marker;
    console.info(arr_markers);
}

