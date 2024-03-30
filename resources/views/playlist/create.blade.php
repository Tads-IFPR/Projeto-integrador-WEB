@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Crie uma Playlist</h1>
    <form action="" method="POST">
        @csrf
        <div class="form-group">
            <div>
                <label for="name">Nome da Playlist</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div>
                <label for="is_public">Pública</label>
                <input type="checkbox" class="form-control" id="is_public" name="is_public">
            </div>
            <div>
                <label for="cover_path">Imagem da Playlist</label>
                <input type="file" class="form-control" id="cover_path" name="cover_path">
            </div>
        </div>
        
        <x-secondary-button>Create</x-secondary-button>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>

<div>
    <a href="{{ route('playlist.index') }}">Voltar</a>
</div>

@endsection