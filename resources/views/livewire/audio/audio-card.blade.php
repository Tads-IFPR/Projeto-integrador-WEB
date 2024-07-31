<div @class(['audio-card d-flex justify-content-between px-1 {{$class}}', 'is-playing' => $isPlaying])
    style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;"
    wire:click='play'
>
    <div class="d-flex justify-content-center align-items-center" style="min-width: 50px">
        <img width="50px"
            src="{{ $audio->cover_path !== null ? route('audio.show.image', $audio) : '/imgs/wave-sound.png'}}"
            @style(['filter: invert(1)' => $audio->cover_path === null])
            class="h-100" alt="Audio cover image">
        <button class="play">
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
        <div class="edit-form">
            <a href="{{ route('audio.edit', $audio->id) }}" wire:navigate>
                <span class="material-symbols-outlined">
                    edit
                </span>
            </a>
        </div>
    </div>
</div>
