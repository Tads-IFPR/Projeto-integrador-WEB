<div class="audio-card d-flex justify-content-between {{$class}}"
    style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;"
>
    <img height="100%" src="{{ route('audio.show.image', $audio) }}" alt="Audio cover image">
    <button wire:click='play' class="play">
        <span class="material-symbols-outlined">play_arrow</span>
    </button>
    <div class="d-flex flex-column">
        {{-- <h3 class="short-name">{{ $audio->shortName }} <span class="rest-name">{{ $audio->restName }}</span></h3> --}}
        <h3 class="name">{{ $audio->name }}</h3>
        <h4>{{ $audio->author }}</h4>
    </div>
    <div class="d-flex">
        <form action="{{ route('audio.destroy', $audio->id) }}" method="POST" class="delete-form">
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
