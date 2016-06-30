<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Zooom Test</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css">
    <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('css/style.css') }}">
    
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    
    
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">

    <div id="alert_messages">
        <div class="alert alert-success" style="margin-top:1em; display:none;">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <span>
                <strong class="content"></strong> 
            </span>
        </div>
        <div class="alert alert-danger" style="margin-top:1em; display:none;">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <span class="content"></span>
        </div>
    </div>
    <div>
        @yield('content')
    </div>
    <!-- JavaScripts -->
    <script src="//code.jquery.com/jquery-2.2.3.min.js"></script>    
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>        
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.GOOGLE_MAP_KEY')}}&libraries=geometry,places"
        ></script>
    
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

@stack('scripts')
</body>
</html>
