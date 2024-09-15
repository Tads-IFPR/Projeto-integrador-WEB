<div class="d-flex flex-column" id="playlists">

    <div class="d-flex justify-content-between w-100">
        <h2 class="cfs-1 bolder">Playlists</h2>
        <a href="{{route('playlist.create')}}" class="button-default px-4 py-1" wire:navigate>New</a>
    </div>

    <livewire:playlist.playlist-list :playlists="$playlists" class="d-flex w-100 wrap" />
    
</div>
