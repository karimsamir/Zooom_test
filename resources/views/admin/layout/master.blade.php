<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{URL('bower_components/bootstrap/dist/css/bootstrap.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{URL('css/style.css')}}" />
    @yield('styles')
</head>
<body>
<div class="main">
    @yield('content')
</div>
</body>
</html>