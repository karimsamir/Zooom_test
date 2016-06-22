@extends('layouts.app')

@section('content')

<div class="col-sm-10">
    <!--<div class="panel panel-default tabs">-->

        @if(count($events) > 0)
        
        <div id="accordion">
            @foreach($events as $event)
            <h3>{{$event->title}}</h3>
            <div>
                {!! Form::model($event, [
                'name' => 'frm_edit_section', 
                'route' => 'storeEvent',
                'class' => 'form-horizontal']) !!}
                @include('admin.event.includes.form',
                ['submitButtonText'  => 'Save'
                ])
            {!! Form::close() !!}
            </div>
            @endforeach
        </div>

        
        @else
        <div style="text-align: center;">No events found</div>
        @endif

    <!--</div>-->
</div>

@endsection
