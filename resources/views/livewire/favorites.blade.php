<div class="container-fluid">
    <div class="d-flex flex-column w-100">
        <div class="d-flex flex-column" id="playlists">
            <div class="d-flex justify-content-between w-100">
                <h2 class="cfs-1 bolder">Playlists</h2>
            </div>
            <livewire:playlist.playlist-list :playlists="$playlists" class="d-flex w-100 wrap" />
        </div>

        <div class="d-flex flex-column" id="audios">
            <div class="d-flex justify-content-between w-100">
                <h2 class="cfs-1 bolder">Musics</h2>
            </div>
            <div wire:click='play'>
                <livewire:audio.audio-list class="d-flex w-100 wrap" :audios="$audios" />
            </div>
        </div>
    </div>
</div>
