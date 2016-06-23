@include('errors.list')

{!! Form::hidden('id') !!}
        
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
    {!! Form::label('description', 'Description', array('class' => 'col-sm-2 control-label')) !!}
    {!! Form::textarea('description', null, [

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
    {!! Form::label('zip', 'Zip', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('zip', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter event zip'
        ]) !!}
    </div>
    @if ($errors->has('zip'))
    <p class="help-block alert alert-danger">{{ $errors->first('zip') }}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('latitude', 'Latitude', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('latitude', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter event latitude'
        ]) !!}
    </div>
    @if ($errors->has('latitude'))
    <p class="help-block alert alert-danger">{{ $errors->first('latitude') }}</p>
    @endif
</div>

<div class="form-group">
    {!! Form::label('longitude', 'Longitude', array('class' => 'col-sm-2 control-label')) !!}
    <div class="col-sm-10">
        {!! Form::text('longitude', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter event longitude'
        ]) !!}
    </div>
    @if ($errors->has('longitude'))
    <p class="help-block alert alert-danger">{{ $errors->first('longitude') }}</p>
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

<div class="col-md-12">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-success pull-right']) !!}
</div>
