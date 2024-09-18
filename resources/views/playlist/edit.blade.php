@extends('layouts.app')

@section('content')

    <h1>Create a Playlist</h1>
    <form action="{{ route('playlist.update', $playlist->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <x-input type="text" name="name" placeholder="Name" class="w-100" value="{{$playlist->name}}"/>

        <div>
            <label for="is_public">Public</label>
            <input type="checkbox" class="form-control" id="is_public" name="is_public" value="1" {{$playlist->is_public ? 'checked' : ''}}>
        </div>
        <div>
            <label for="cover_path">Playlist Image</label>
        <!--<input type="file" class="form-control" id="cover_path" name="cover_path"> -->
            <x-input type="file" name="cover_path" id="cover" accept="image/*" class="py-2 w-100" />
        </div>
       
        <!--<x-button type="submit" id="submit" class="px-4 py-1 bolder mt-3">Create</x-button>-->

        <button type="submit" class="button-default px-4 py-1" id="edit-save">Save</button>
            
        
    </form>



<div >
    <a href="{{ route('playlist.show', $playlist->id, $audios) }}" class="button-default px-4 py 1">Back to Playlist</a>
</div>

<style>
    form {
        display: flex;
        flex-direction: column;
        width: 30vw;
        margin: 0 auto;
    }
</style>

@endsection