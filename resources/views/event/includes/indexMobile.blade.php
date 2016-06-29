<!--<img src="https://maps.googleapis.com/maps/api/staticmap?center=63.259591,-144.667969&zoom=6&size=600x400
     &markers=color:blue%7Clabel:S%7C62.107733,-145.541936&markers=size:tiny%7Ccolor:green%7CDelta+Junction,AK
     &markers=size:mid%7Ccolor:0xFFFF00%7Clabel:C%7CTok,AK&key=AIzaSyC8cZEQ4NUtn43xVU8eZa-xQtGlo1t3p9Y">-->


@foreach($categories as $catKey => $category)

    @if(count($category["events"]) > 0)

        @foreach($category["events"] as $eventKey => $event)
        <?php $staticMarkersCounter = $staticMarkersCounter+1; 
        $markerIndex = $eventKey+1;
        ?>
        
            @if($staticMarkersCounter < 11)
                <?php $staticMarkers .= "&markers=color:red%7Clabel:$markerIndex%7C" . $event->latitude . "," . $event->longitude; ?>

            @endif
    
        
        @endforeach

    @endif

@endforeach

<img src="https://maps.googleapis.com/maps/api/staticmap?size=600x400{{$staticMarkers}}&key=AIzaSyC8cZEQ4NUtn43xVU8eZa-xQtGlo1t3p9Y">
