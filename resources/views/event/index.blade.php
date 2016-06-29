@extends('layouts.app')

@section('content')

<div id="all_events">
    <div id="map_canvas"></div>

    @if(count($categories) > 0)
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 filter_category_list_container">
        <div class="row">
            @foreach($categories as $catKey => $category)
            <div class="checkbox-inline">
                <label>
                    <input type="checkbox" name="category" class="filter_category_list"
                           value="{{$category->id}}">
                    {{$category->category_name}}
                </label>
            </div>
            @endforeach
        </div>

    </div>
    @endif
    
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row col-sm-9">
            <input type="search" id="autocomplete" name="autocomplete" class="form-control"
                   placeholder="Search">

        </div>
    </div>
    
</div>


@foreach($categories as $catKey => $category)


<div class="category_group 
     @if($catKey % 2 == 0) 
     col-xs-7 col-sm-7 col-md-7 col-lg-7
     @else
     col-xs-4 col-sm-4 col-md-4 col-lg-4
     @endif
     ">
    <h3 class="box cat_title" style="text-align: center;">{{$category->category_name}}</h3>
    <input type="hidden" name="category_id" value="{{$category->id}}">
    @if(count($category["events"]) > 0)

    @foreach($category["events"] as $eventKey => $event)

    <div class="event_container
         @if($catKey % 2 == 0) 
         col-xs-6 col-sm-6 col-md-6 col-lg-6 
         @else
         col-xs-12 col-sm-12 col-md-12 col-lg-12
         @endif">
        <div class="row box">
            <!--<div class="info">-->
            <!--<h4 class="text-center">Title</h4>-->
            <div class="row event_dates">
                <div class="col-sm-9" style="text-align: left;">
                    {{\Carbon\Carbon::createFromTimeStamp(strtotime($event->start_date))->format('d.m')}} - 
                    {{\Carbon\Carbon::createFromTimeStamp(strtotime($event->end_date))->format('d.m.Y')}}
                </div>
                <div class="col-sm-3" style="text-align: right;">
                    <span>{{$category->category_name }}</span>
                </div>
            </div>

            <div class="row event_title_container">
                <div class="col-sm-10" style="text-align: left;">
                    <strong class="event_title">{{$event->title}}</strong>
                </div>

                <div class="col-sm-2" style="text-align: right;">
                    <span class="marker_index">{{$eventKey +1 }}</span>
                </div>
            </div>


            <div class="row col-sm-12 event_country">
                <strong>{{$event->country_name}}/{{$event->country_code}}</strong>
            </div>


            <input type="hidden" name="event_id" value="{{$event->id}}">
            <input type="hidden" name="latitude" value="{{$event->latitude}}">
            <input type="hidden" name="longitude" value="{{$event->longitude}}">
            <input type="hidden" name="description" value="{{$event->description}}">


            <button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 btn btn-info show_on_map">
                Show on Map
            </button>


            <!--</div>-->
        </div>
    </div>
    @endforeach
    @else
    <div>No Events</div>
    @endif
</div>
@endforeach


<div class="infowindow_container hidden">
    <div class="infowindow">
        <div class="event_dates"></div>
        <div class="event_title"></div>
        <div class="col-sm-12 event_country"></div>
<!--        <input type="hidden" name="event_id" value="">
        <button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 btn btn-info rsvp_event">
            RSVP
        </button>-->
    </div>

</div>

</div>

@push('scripts')

<script type="text/javascript" src="{{ asset('js/map.js')}}"></script>

<script>
$(document).ready(function () {

    initMap();

    $(".show_on_map").each(function (index) {
//        $(this).click();
        var show_marker = false;
        
        var category_id = $(this).parents(".category_group").find("input[name=category_id]").val();

        if (index < 10) {
            show_marker = true;
        }

        addMarker($(this).parents(".event_container"), category_id, show_marker);

    });

});

$(".show_on_map").click(function (e) {
    e.preventDefault();
    var category_id = $(this).parents(".category_group").find("input[name=category_id]").val();


    addMarker($(this).parents(".event_container"), category_id, true);

    // scroll to map to show marker
    $('html,body').animate({
        scrollTop: $("#map_canvas").offset().top},
            'slow');
});

$(".filter_category_list_container").click(function () {

    var filters = [];

    $(".filter_category_list").each(function () {
        if (this.checked) {
            filters.push($(this).val());
        }
    });

    filterMarkers(filters);

});



</script>

@endpush  
@endsection
