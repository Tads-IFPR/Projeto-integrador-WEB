<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tojoja') }}</title>

        <link rel="stylesheet" href="/bootstrap-5.3.3/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

        @stack('styles')

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        @yield('content')

        @stack('scripts')

        <script src="/bootstrap-5.3.3/js/bootstrap.min.js"></script>
    </body>
</html>
