@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex flex-column w-100">
        <div class="d-flex justify-content-between w-100">
            <h2 class="cfs-1 bolder">{{ $playlist->name }}</h2>
            <a href="{{ route('playlist.edit', $playlist->id) }}" class="button-default px-4 py-1" wire:navigate>Edit</a>
        </div>
        <div class="d-flex w-100 wrap">

            @foreach ($playlist->audios as $audio)
                <livewire:audio-card :audio="$audio" :playlists="$playlists" :key="$audio->id" class="mt-3"/>
            @endforeach
            
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
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