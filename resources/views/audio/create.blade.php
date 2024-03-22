@extends('layouts.app')


    @section('content')
        <form action="{{ route('audio.store') }}" method="POST" enctype="multipart/form-data">

            @csrf
            <label for="name">Nome</label><br>
            <input type="text" name="name" placeholder="Nome"><br><br>

            <label for="artist">Artista</label><br>
            <input type="text" name="artist" placeholder="Artista"><br><br>

            <label for="file">Áudio</label><br>
            <input type="file" name="file" accept="audio/*" required><br><br>

            <label for="cover">Capa do Álbum</label><br>
            <input type="file" name="cover" accept="image/*" ><br><br>

            <button type="submit">Adicionar Áudio</button><br>

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

