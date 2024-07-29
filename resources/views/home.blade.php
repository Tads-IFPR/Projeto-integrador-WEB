@extends('layouts.app')

@section('content')
<livewire:audio-upload />
<div class="container-fluid">
    <div class="d-flex flex-column w-100">
        <div class="d-flex flex-column" id="playlists">
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <h2 class="cfs-1 bolder">Playlists</h2>
                    <button class="button-default px-4 py-1">New</button>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column" id="audios">
            <div class="d-flex justify-content-between w-100">
                <h2 class="cfs-1 bolder">Musics</h2>
                <a href="{{route('audio.create')}}" class="button-default px-4 py-1" wire:navigate>New</a>
            </div>
            <div class="d-flex w-100 wrap">
                @foreach ($audios as $audio)
                    <livewire:audio-card :$audio :key="$audio->id" class="mt-3"/>
                @endforeach
            </div>
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
    }

    .wrap {
        flex-wrap: wrap;
    }

    .audio-card {
        width: 20%;
        min-width: 20%;
    }

    @media screen and (max-width: 800px) {
        .audio-card {
            width: 100%;
            min-width: 100%;
        }
    }
</style>
@endpush
