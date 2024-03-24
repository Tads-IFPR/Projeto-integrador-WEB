
@extends('layouts.app')

@section('content')

    @foreach ($audios as $audio)
        <x-audios.card :audio="$audio" />
@endforeach
@endsection

