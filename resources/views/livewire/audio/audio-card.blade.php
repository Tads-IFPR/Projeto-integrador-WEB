<div @class(['audio-card d-flex justify-content-between px-1 ' . $class, 'is-playing' => $isPlaying])
    style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;"
>
    <div class="d-flex justify-content-center align-items-center" style="min-width: 50px" wire:click='play'>
        <img width="50px"
            src="{{ $audio->cover_path !== null ? route('audio.show.image', $audio) : '/imgs/wave-sound.png'}}"
            @style(['filter: invert(1)' => $audio->cover_path === null])
            class="h-100" alt="Audio cover image">
        <button class="play">
            <span class="material-symbols-outlined">play_arrow</span>
        </button>
    </div>
    <div class="d-flex flex-column ps-3 pe-1 w-100" wire:click='play'>
        <h3 class="name">{{ $audio->name }}</h3>
        <h4>{{ $audio->author }}</h4>
    </div>
    <div class="d-flex align-items-center me-1">
        <span @class(['material-symbols-outlined like cursor-pointer', 'like-check' => $audio->userLiked])
            wire:click="toggleLike"
        >
            favorite
        </span>
    </div>
    @if ($audio->isCurrentUserOwner)
        <div class="options-audio cursor-pointer"
            target="{{$audio->id}}"
            wire:prevent
            onclick="toggleDropDownAudio(this.attributes.target.nodeValue)"
        >
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="M480-160q-33 0-56.5-23.5T400-240q0-33 23.5-56.5T480-320q33 0 56.5 23.5T560-240q0 33-23.5 56.5T480-160Zm0-240q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm0-240q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Z"/>
            </svg>
        </div>
        <div id="backdrop-audio-{{$audio->id}}" target="{{$audio->id}}" class="backdrop-audio" style="display: none;"></div>
        <div id="option-audio-{{$audio->id}}" class="option-audio flex-column align-items-center" style="display: none;">
            <form action="{{ route('audio.destroy', $audio->id) }}" method="POST" class="w-100">
                @csrf
                @method('DELETE')
                <button type="submit" class="d-flex align-items-center w-100 p-0 border-0 bg-transparent">
                    <div class="d-flex align-items-center w-100">
                        <span class="material-symbols-outlined me-1">
                            delete
                        </span>
                        <span>Delete</span>
                    </div>
                </button>
            </form>
            <a href="{{ route('audio.edit', $audio->id) }}" wire:navigate class="d-flex align-items-center w-100 h-100 p-2 text-decoration-none">
                <div class="d-flex align-items-center w-100">
                    <span class="material-symbols-outlined me-1">
                        edit
                    </span>
                    <span>Edit</span>
                </div>
            </a>
        </div>
    @endif
</div>
