@include('errors.list')

<!--<div class="col-md-6">-->
<!--<div class="row form-inline">-->

{!! Form::hidden('event_id', null) !!}

<div class="form-group">
    {!! Form::label('country', 'Country', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::select('country_id', $countries, null, [
        'placeholder' => 'Select',
        'class' => 'form-control']) !!}
    </div>
    @if ($errors->has('country_id'))
    <p class="help-block alert alert-danger">{{ $errors->first('country_id') }}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('category', 'Category', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::select('category_id', $categories, null, [
        'placeholder' => 'Select',
        'class' => 'form-control']) !!}
    </div>
    @if ($errors->has('category_id'))
    <p class="help-block alert alert-danger">{{ $errors->first('category_id') }}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('title', 'Title', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('title', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter event title'
        ]) !!}
    </div>
    @if ($errors->has('title'))
    <p class="help-block alert alert-danger">{{ $errors->first('title') }}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('description', 'Event Description', array('class' => 'col-sm-2 control-label')) !!}
    {!! Form::textarea('description', null, [
    'class' => 'form-control'
    ]) !!}
</div>


<div class="form-group">
    {!! Form::label('location', 'Location', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('location', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter event location'
        ]) !!}
    </div>
    @if ($errors->has('location'))
    <p class="help-block alert alert-danger">{{ $errors->first('location') }}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('start_date', 'Start date', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::date('start_date', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter event start date'
        ]) !!}
    </div>
    @if ($errors->has('start_date'))
    <p class="help-block alert alert-danger">{{ $errors->first('start_date') }}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('end_date', 'End date', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::date('end_date', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter event end date'
        ]) !!}
    </div>
    @if ($errors->has('end_date'))
    <p class="help-block alert alert-danger">{{ $errors->first('end_date') }}</p>
    @endif
</div>

<hr>
<!--</div>-->

<div class="col-md-12">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success pull-right']) !!}
</div>
