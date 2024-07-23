<div class="audio-card d-flex justify-content-between px-1 {{$class}}"
    style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;"
>
    <div class="d-flex justify-content-center align-items-center" style="min-width: 50px">
        <img width="50px" src="{{ route('playlist.show.image', $playlist) }}" class="h-100" alt="Playlist cover image">
        <a href="{{ route('playlist.show', $playlist->id) }}" class="play">
            <span class="material-symbols-outlined">play_arrow</span>
        </a>
    </div>
    <div class="d-flex flex-column ps-3 pe-1 w-100">
        <h3 class="name">{{ $playlist->name }}</h3>
    </div>
    <div class="d-flex align-items-center">
        <form action="{{ route('playlist.destroy', $playlist->id) }}" method="POST" class="delete-form me-2">
            @csrf
            @method('DELETE')
            <button type="submit">
                <span class="material-symbols-outlined">
                    delete
                </span>
            </button>
        </form>
        <div class="edit-form">
            <a href="{{ route('playlist.edit', $playlist->id) }}" wire:navigate>
                <span class="material-symbols-outlined">
                    edit
                </span>
            </a>
        </div>
    </div>
</div>
