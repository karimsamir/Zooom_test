<div class="col-sm-10">
    @if(count($events) > 0)
        
        <div id="accordion">
            @foreach($events as $key => $event)
               
                <h3>
                    <span class="event_title title_{{$key}}">{{$event->title}}</span>

                    {!! Form::open([
                        'method' => 'DELETE',
                        'name' => 'frm_delete_event',
                        'route' => ['deleteEvent', $event->id]]) !!}

                        {!! Form::button( 'Delete<i class="fa fa-trash fa-lg"></i>', 
                        ['type' => 'submit',
                        'class' => 'btn btn-danger pull-right delete_event', 
                        'data-id' => $event->id] ) !!}
                        
                        {!! Form::hidden( 'event_title', $event->title ) !!}
                        
                    {!! Form::close() !!}
                </h3>

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