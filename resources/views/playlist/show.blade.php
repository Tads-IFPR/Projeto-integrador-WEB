@extends('layouts.app')

@section('content')
    <div class="container-audio">
        <div class="d-flex justify-content-between w-100">
            <h1 class="cfs-1 bolder">{{ $playlist->name }}</h1>
            <a href="{{ route('playlist.edit', $playlist->id) }}" class="button-default px-4 py-1" wire:navigate>Edit</a>
        </div>
        
        <div class="playlist-audios">
            <livewire:audio.audio-list class="d-flex w-100 wrap" :audios="$audios" :playlist="$playlist"/>
        </div>
    </div>
@endsection
