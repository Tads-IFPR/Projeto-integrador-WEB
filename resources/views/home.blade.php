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
        <livewire:home.audios />
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
