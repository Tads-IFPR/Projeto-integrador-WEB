@extends('layouts.app')

@section('content')

    <h1>Crie uma Playlist</h1>
    <form action="{{ route('playlist.store') }}" method="POST" enctype="multipart/form-data">

        @csrf
        <x-input type="text" name="name" placeholder="Name" class="w-100" />

        <div>
            <label for="is_public">Pública</label>
            <input type="checkbox" class="form-control" id="is_public" name="is_public">
        </div>
        <div>
            <label for="cover_path">Imagem da Playlist</label>
            <x-input type="file" name="cover_path" id="cover" accept="image/*" class="py-2 w-100" />
        </div>
    
        <!--<x-button type="submit" id="submit" class="px-4 py-1 bolder mt-3">Create</x-button>-->

        <button type="submit" class="btn btn-primary">Criar</button>
            
        
    </form>



<div>
    <a href="{{ route('home') }}">Voltar</a>
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