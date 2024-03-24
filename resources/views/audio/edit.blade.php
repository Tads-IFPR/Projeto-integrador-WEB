@extends('layouts.app')

    @section('content')


    <h1>Editar Áudio</h1>
    <form action="{{ route('audio.update', $audio->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <label for="name">Nome</label><br>
        <input type="text" name="name" placeholder="Nome" value="{{ $audio->name ?? '' }}"><br><br>

        <label for="artist">Artista</label><br>
        <input type="text" name="artist" placeholder="Artista" value="{{ $audio->artist ?? '' }}"><br><br>

        <label for="file">Áudio</label><br>
        <input type="file" name="file" accept="audio/*"><br><br>

        <label for="cover">Capa do Álbum</label><br>
        <input type="file" name="cover" accept="image/*" ><br><br>

        <button type="submit">Atualizar Áudio</button><br>

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

