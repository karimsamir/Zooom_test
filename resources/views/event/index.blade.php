@extends('layouts.app')

@section('content')
<h1>dddddddddddddddddd</h1>
<div id="all_events">
    <div id="map_canvas"></div>
</div>




@foreach($categories as $catKey => $category)

<div class="category_group col-xs-5 col-sm-5 col-md-5 col-lg-5">
    <h3 class="box" style="text-align: center;">{{$category->category_name}} </h3>

    @if(count($category["events"]) > 0)
    
    @foreach($category["events"] as $eventKey => $event)

    <div class="event_container
         @if($catKey % 2 == 0) 
     col-xs-6 col-sm-6 col-md-6 col-lg-6 
     @else
     col-xs-10 col-sm-10 col-md-10 col-lg-10
     @endif">
        <div class="box">
            <div class="info">
                <!--<h4 class="text-center">Title</h4>-->
                <p>{{\Carbon\Carbon::createFromTimeStamp(strtotime($event->start_date))->format('d.m')}} - 
                    {{\Carbon\Carbon::createFromTimeStamp(strtotime($event->end_date))->format('d.m.Y')}}</p>
                <p>{{$event->title}} <span style="float: right;">{{$eventKey +1 }}</span></p>
                <p>{{$event->country_name}}/{{$event->country_code}}</p>
                <a href="" class="btn">
                    Show on Map
                </a>

            </div>
        </div>
    </div>
    @endforeach
    @else
    <div>No Events</div>
    @endif
</div>
@endforeach



@push('scripts')

<script type="text/javascript" src="{{ asset('js/map.js')}}"></script>

<script>

//initMap();
$(document).ready(function () {
    initMap();
});
</script>

@endpush  
@endsection
