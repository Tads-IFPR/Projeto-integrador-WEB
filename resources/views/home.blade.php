@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <livewire:audio-upload />

    <div class="d-flex flex-column w-100">
        <livewire:home.playlists />
        <livewire:home.audios />
    </div>
</div>
@endsection

@push('styles')
<style>
    #playlists {
        height: 30vh;
    }

    #audios {
        height: 70vh;
    }

    .wrap {
        flex-wrap: wrap;
    }

    .audio-card {
        width: 20%;
        min-width: 20%;
    }

    .playlist-card {
        width: 20%;
        min-width: 20%;
    }

    @media screen and (max-width: 800px) {
        .audio-card {
            width: 100%;
            min-width: 100%;
        }

        .playlist-card {
            width: 100%;
            min-width: 100%;
        }
    }
</style>
@endpush
