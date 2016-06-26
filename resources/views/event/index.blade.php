@extends('admin.layouts.app')

@section('content')
<div id="all_events">
    @include('admin.event.includes.ajaxIndex')
</div>

@push('scripts')

<script type="text/javascript" src="{{ asset('js/map.js')}}"></script>

@endpush  
@endsection
