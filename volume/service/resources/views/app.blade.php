<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- YOUR ENTRIES -->
        <link rel="icon" href="{{ asset('/favicon.ico') }}">
        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <!-- BootstrapCSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <style>
        .navbar-toggler { border: none; background: transparent !important; } 
        .navbar-toggler:focus { outline: none; background: transparent !important; }
        .navbar-toggler .icon-bar { background-color: #fff; transform: rotate(0deg) translate(0px, 0px); transition: ease all .2s; }
        .navbar-toggler .icon-bar { display: block; width: 22px; height: 2px; border-radius: 1px; }
        .navbar-toggler .icon-bar+.icon-bar { margin-top: 4px; } 
        .icon-bar:nth-child(2) { width: 16px; transition: ease all .2s; } 
        .navbar-toggler:hover>.icon-bar:nth-child(2) { width: 22px; transition: ease all .2s; }
        .navbar-toggler:active>.icon-bar:nth-child(2) { width: 22px; transition: ease all .2s; } 
        .navbar-toggler:not(.collapsed) .icon-bar:nth-child(1) { transform: rotate(45deg) translate(5px, 4px); transition: ease all .2s; }
        .navbar-toggler:not(.collapsed) .icon-bar:nth-child(2) { opacity: 0; transition: ease all .2s; }
        .navbar-toggler:not(.collapsed) .icon-bar:nth-child(3) { transform: rotate(-45deg) translate(4px, -4px); transition: ease all .2s; }
        </style>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- i18n -->
        @translations

        <!-- Scripts -->
        @routes
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="d-flex flex-column h-100">
        @inertia
    </body>
</html>
