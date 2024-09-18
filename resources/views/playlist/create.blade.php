@extends('layouts.app')

@section('content')
    <div id="playlist-create">
    
        <form action="{{ route('playlist.store') }}" method="POST" enctype="multipart/form-data" >
            <div>
                <h1 id="title">Crie uma Playlist</h1>
                @csrf
                <x-input type="text" name="name" placeholder="Name" class="w-100" />

            </div>
            
            
            <div>
                <label for="is_public">Pública</label>
                <input type="checkbox" class="form-control" id="is_public" name="is_public">
            </div>
            <div>
                <label for="cover_path">Imagem da Playlist</label>
                <x-input type="file" name="cover_path" id="cover" accept="image/*" class="py-2 w-100" />
            </div>

            <div class="d-flex flex-column align-items-center">
                <x-button type="submit" id="create" class="px-4 py-1 bolder mt-3">Create</x-button>
            </div>
                
            
        </form>
    </div>





@endsection