<div class="playlist-card d-flex justify-content-between px-1 {{$class}}" style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;" id="seila">
    <div class="d-flex justify-content-center align-items-center" style="min-width: 50px" wire:click='play' >
        <img width="50px" src="{{ route('playlist.show.image', $playlist) }}" class="h-100" alt="Playlist cover image">
        <a href="{{ route('playlist.show', $playlist->id) }}" class="play"></a>
    </div>
    <div class="d-flex flex-column ps-3 pe-1 w-100" wire:click='play'>
        <div wire:click='play'>
            <h3 class="name">{{ $playlist->name }}</h3>
        </div>
        <div>
            @if($playlist->audios->count() > 0)
                <span class="badge">{{ $playlist->audios->count() }} Audios</span>
            @endif
        </div>
    </div>
    <div class="d-flex align-items-center me-1" >
        <span @class(['material-symbols-outlined like cursor-pointer', 'like-check' => $playlist->userLiked])
            wire:click="toggleLike"
        >
            favorite
        </span>
    </div>
    @if ($playlist->isCurrentUserOwner)
        <div class="options-playlist cursor-pointer"
            target="{{$playlist->id}}"
            wire:prevent
            onclick="toggleDropDownPlaylist(this.attributes.target.nodeValue)"
        >
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                <path d="M480-160q-33 0-56.5-23.5T400-240q0-33 23.5-56.5T480-320q33 0 56.5 23.5T560-240q0 33-23.5 56.5T480-160Zm0-240q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm0-240q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Z"/>
            </svg>
        </div>
        <div id="backdrop-playlist-{{$playlist->id}}" target="{{$playlist->id}}" class="backdrop-playlist" style="display: none;"></div>
        <div id="option-playlist-{{$playlist->id}}" class="option-playlist flex-column align-items-center" style="display: none;">
            <form action="{{ route('playlist.destroy', $playlist->id) }}" method="POST" class="w-100">
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
            <a href="{{ route('playlist.edit', $playlist->id) }}" wire:navigate class="d-flex align-items-center w-100 h-100 p-2 text-decoration-none">
                <div class="d-flex align-items-center w-100">
                    <span class="material-symbols-outlined me-1">
                        edit
                    </span>
                    <span>Edit</span>
                </div>
            </a>
            <div>
                <span class="material-symbols-outlined me-1">
                    add_circle
                </span>
                <span wire:click="modal">
                    Add in this playlist
                </span>
            </div>
            <div wire:click="togglePrivacy">
                <span class="material-symbols-outlined me-1">
                    language
                </span>
                {{$playlist->is_public ? 'Turn private' : 'Turn public'}}
            </div>
        </div>
      
    @endif
</div>




