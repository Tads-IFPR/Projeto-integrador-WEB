<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tojoja') }}</title>

        <link rel="stylesheet" href="/bootstrap-5.3.3/css/bootstrap.min.css">
        <script src="/bootstrap-5.3.3/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/audio.css">
        <link rel="stylesheet" href="/css/navbar.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link rel="stylesheet" href="/css/playlist.css">

        @stack('styles')

        @livewireStyles
    </head>
    <body>
        @persist('navbar')
            <livewire:navbar />
        @endpersist

        @yield('content')

        @stack('scripts')
        @livewireScripts
        @persist('player')
            @isset($playlist)
                <livewire:audio-player :playlist="$playlist" :audios="$audios" />
            @else
                <livewire:audio-player />
            @endisset
        @endpersist
        @php
            $isPlaylistShow = $isPlaylistShow ?? false;
        @endphp
        <livewire:audio-modal :isPlaylistShow="$isPlaylistShow">
    </body>
</html>
