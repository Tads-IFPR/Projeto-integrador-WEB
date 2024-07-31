<div class="show-audio-container">
    <div class="show-audio px-1 {{$class}}"
        style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;">
        <div class="d-flex justify-content-center align-items-center" style="min-width: 50px;">
            <img width="50px" src="{{ route('audio.show.image', $audio) }}" class="h-100" alt="Audio cover image">
            <button wire:click='play' class="play-button">
                <span class="material-symbols-outlined">play_arrow</span>
            </button>
        </div>
        <div class="audio-info">
            <h3 class="name">{{ $audio->name }}</h3>
            <h4>{{ $audio->author }}</h4>
        </div>
        <div class="actions">
            <form action="{{ route('playlist.removeAudio', ['playlist' => $playlist->id, 'audio' => $audio->id]) }}" method="POST" class="remove-form">
                @csrf
                @method('DELETE')
                <input type="hidden" name="playlist_id" value="{{ $playlist->id }}">
                <input type="hidden" name="audio_id" value="{{ $audio->id }}">
                <button type="submit" class="remove-button">
                    <span class="material-symbols-outlined">remove</span>
                </button>
            </form>
        </div>
    </div>
</div>
