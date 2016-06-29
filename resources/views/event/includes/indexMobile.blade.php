@foreach($categories as $catKey => $category)

@if(count($category["events"]) > 0)

@foreach($category["events"] as $eventKey => $event)
<?php
$staticMarkersCounter = $staticMarkersCounter + 1;
$markerIndex = $eventKey + 1;
?>

@if($staticMarkersCounter < 11)
<?php $staticMarkers .= "&markers=color:red%7Clabel:$markerIndex%7C" . $event->latitude . "," . $event->longitude; ?>

@endif


@endforeach

@endif

@endforeach
<div id="staticMap">
    <img src="https://maps.googleapis.com/maps/api/staticmap?size=200x150&scale=2{{$staticMarkers}}&key=AIzaSyC8cZEQ4NUtn43xVU8eZa-xQtGlo1t3p9Y">
</div>