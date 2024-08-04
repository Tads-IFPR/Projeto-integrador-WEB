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
</style>
@endpush
