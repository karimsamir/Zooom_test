<div class="col-sm-10">
    @if(count($events) > 0)
        
        <div id="accordion">
            @foreach($events as $key => $event)
                <h3 class="event_title title_{{$key}}">{{$event->title}}</h3>
                <div>
                    {!! Form::model($event, [
                    'method' => 'PUT',
                    'name' => 'frm_update_event', 
                    'route' => ['updateEvent', $event->id],
                    'class' => 'form-horizontal',
                    'data-index' => $key
                    ]) !!}

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

</div>
