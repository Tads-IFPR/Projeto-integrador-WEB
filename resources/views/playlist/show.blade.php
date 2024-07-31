@extends('layouts.app')

@section('content')
<div class="container-audio">

    <div class="d-flex flex-column w-100">
        <div class="d-flex justify-content-between w-100">
            <h2 class="cfs-1 bolder">{{ $playlist->name }}</h2>
            <a href="{{ route('playlist.edit', $playlist->id) }}" class="button-default px-4 py-1" wire:navigate>Edit</a>
        </div>
        <div class="wrap"> 

            @foreach ($playlist->audios as $audio)
                
                <livewire:show-audio :audio="$audio" :key="$audio->id" :playlistId="$playlist->id" class="show-audio mt-3"/>
            @endforeach
            
        </div>
    </div>
</div>
@endsection


