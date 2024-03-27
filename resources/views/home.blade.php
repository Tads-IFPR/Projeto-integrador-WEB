@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column w-100">
        <div class="d-flex flex-column" id="playlists">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <h2>PLaylists</h2>
                    <button class="button-default">New</button>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column" id="audios">
            <div class="d-flex justify-content-between w-100">
                <h2>Audios</h2>
                <a href="{{route('audio.create')}}" class="button-default">New</a>
            </div>
            @foreach ($audios as $audio)
                <livewire:audio-card :$audio :key="$audio->id"/>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    #playlists {
        height: 30vh;
        overflow: auto;
    }

    #audios {
        height: 70vh;
        overflow: auto;
    }

    .audio-card {
        width: 20%;
        max-width: 20%;
    }

    @media screen and (max-width: 1300px) {
        .audio-card {
            width: 100%;
            max-width: 100%;
        }
    }
</style>
@endpush
