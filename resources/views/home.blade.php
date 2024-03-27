@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @foreach ($audios as $audio)
            <livewire:audio-card :$audio :key="$audio->id" class="col-3" />
        @endforeach
    </div>
</div>
@endsection
