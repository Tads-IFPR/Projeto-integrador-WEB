<div class="d-flex flex-column" id="playlists">
    <div class="d-flex justify-content-between w-100">
        <h2 class="cfs-1 bolder">Playlists</h2>
        <a href="{{route('playlist.create')}}" class="button-default px-4 py-1" wire:navigate>New</a>
    </div>
    <div class="d-flex w-100 wrap">
        @foreach ($playlists as $playlist)
            <livewire:playlist-card :$playlist :key="$playlist->id" class="mt-3"/>
        @endforeach
    </div>
</div>

<script>
    let backdropListenersPlaylist = {};

    const toggleDropDownPlaylist = (target) => {
        console.log('toggle')
        const backdropPlaylist = document.getElementById('backdrop-playlist-' + target);
        const options = document.getElementById('option-playlist-' + target);

        if (options.style.display === 'none' || options.style.display === '') {
            options.style.display = 'flex';
            backdropPlaylist.style.display = 'block';

            if (!backdropListenersPlaylist[target]) {
                backdropPlaylist.addEventListener('click', () => toggleDropDownPlaylist(target, true));
                backdropListenersPlaylist[target] = true;
            }
        } else {
            options.style.display = 'none';
            backdropPlaylist.style.display = 'none';
        }
    }

    const optionsPlaylist = document.getElementsByClassName('options-playlist');
    Array.from(optionsPlaylist).forEach(option => {
        option.addEventListener('click', () => toggleDropDownPlaylist(option.attributes.target.nodeValue));
    });
</script>
