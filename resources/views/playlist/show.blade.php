@extends('layouts.app')

@section('content')
    <div class="container-audio">
        <div class="d-flex justify-content-between w-100">
            <h1 class="cfs-1 bolder" id="nome-play">
            <span class="playlist-name">{{ $playlist->name }}</span>
                @if(auth()->id() === $playlist->user_id && $playlist->name !== "Favorites")
                    
                    <button onclick="openPlaylistModal({{ $playlist->id }})" class="button-default px-4 py-1">
                        Add in this playlist
                    </button>
                @endif
            </h1>
        @if($playlist->isCurrentUserOwner && $playlist->name !== "Favorites")
            <a href="{{ route('playlist.edit', $playlist->id) }}" class="button-default px-4 py-1" wire:navigate>Edit</a>
        @endif
        </div>

        @if($audios->isNotEmpty())
            <div class="playlist-audios" id="inicial">
                <livewire:audio.audio-list class="d-flex w-100 wrap" :audios="$audios" :playlist="$playlist"/>
            </div>
        @else
            <div class="no-audio">
                <h1>No audio in this playlist</h1>
            </div>
        @endif
        <livewire:playlist-search/>
    </div>

    <script>
        function openPlaylistModal(playlistId) {
            Livewire.dispatch('openModal', { playlistId: playlistId });
        }
        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('search-playlist', function () {
                var inicialDiv = document.getElementById('inicial');
                if (inicialDiv) {
                    inicialDiv.style.display = 'none';
                }
            });
        });
    </script>

@endsection