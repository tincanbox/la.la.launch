<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'La.Ra.Launch') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- jquery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <!-- bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>

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

        @translations

    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
