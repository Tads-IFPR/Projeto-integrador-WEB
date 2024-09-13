@extends('layouts.app')

@section('content')
    <div class="container-audio">
        <div class="d-flex justify-content-between w-100">
            <h1 class="cfs-1 bolder">{{ $playlist->name }}
                @if(auth()->id() === $playlist->user_id)
                    
                    <button onclick="openPlaylistModal({{ $playlist->id }})" class="button-default px-4 py-1">
                        Add in this playlist
                    </button>
                @endif
            </h1>
            
            <a href="{{ route('playlist.edit', $playlist->id) }}" class="button-default px-4 py-1" wire:navigate>Edit</a>
        </div>

        @if($audios->isNotEmpty())
            <div class="playlist-audios">
                <livewire:audio.audio-list class="d-flex w-100 wrap" :audios="$audios" :playlist="$playlist"/>
            </div>
        @else
            <div class="container-fluid">
                <h1>No audio in this playlist</h1>
            </div>
        @endif
        
    </div>

    <script>
        function openPlaylistModal(playlistId) {
            Livewire.dispatch('openModal', { playlistId: playlistId });
        }
    </script>

@endsection