<div class="audio-card d-flex justify-content-between px-1 {{$class}}"
    style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;"
>
    <div class="d-flex justify-content-center align-items-center" style="min-width: 50px">
        <img width="50px" src="{{ route('audio.show.image', $audio) }}" class="h-100" alt="Audio cover image">
        <button wire:click='play' class="play">
            <span class="material-symbols-outlined">play_arrow</span>
        </button>
    </div>
    <div class="d-flex flex-column ps-3 pe-1 w-100">
        <h3 class="name">{{ $audio->name }}</h3>
        <h4>{{ $audio->author }}</h4>
    </div>
    <div class="d-flex align-items-center">
        <form action="{{ route('audio.destroy', $audio->id) }}" method="POST" class="delete-form me-2">
            @csrf
            @method('DELETE')
            <button type="submit">
                <span class="material-symbols-outlined">
                    delete
                </span>
            </button>
        </form>
        <form action="{{ route('audio.edit', $audio->id) }}" method="GET" class="edit-form">
            @csrf
            <button type="submit">
                <span class="material-symbols-outlined">
                    edit
                </span>
            </button>
        </form>
    </div>
</div>
