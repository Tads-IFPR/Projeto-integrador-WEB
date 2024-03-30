@extends('layouts.app')
@section('content')
    <form action="{{ route('audio.update', $audio->id) }}" method="POST" enctype="multipart/form-data" id="main-form">
        @method('PUT')
        @csrf
        <x-input type="text" name="name" placeholder="Name" class="w-100" value="{{$audio->name}}" />

        <x-input type="text" name="artist" placeholder="Artist" class="mt-3 w-100" value="{{$audio->author}}" />

        <div class="w-100">
            <label for="file" class="mt-3">Audio</label>
            <x-input type="file" name="file" id="file" accept="audio/*" class="py-2 w-100" />
        </div>

        <div class="w-100">
            <label for="cover" class="mt-3">Cover of Album</label>
            <x-input type="file" name="cover" id="cover" accept="image/*" class="py-2 w-100" />
        </div>

        <x-button type="submit" id="submit" class="px-4 py-1 bolder mt-3">Save</x-button>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

@push('styles')
<style>
    #submit {
        width: fit-content;
    }

    #main-form {
        width: 30vw;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
    }
</style>
@endpush
