<div>
    <img src="{{ $audio->cover_path}}" alt="Capa do Álbum">
    <h2>{{ $audio->name }}</h2>
    <form action="{{ route('audio.destroy', $audio->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Deletar</button>
    </form>
    <form action="{{ route('audio.edit', $audio->id) }}" method="GET">
        @csrf
        <button type="submit">Editar</button>
    </form>
</div>
