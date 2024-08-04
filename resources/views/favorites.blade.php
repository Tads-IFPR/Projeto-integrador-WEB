@extends('layouts.app')

@section('content')
    <livewire:favorites />
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
