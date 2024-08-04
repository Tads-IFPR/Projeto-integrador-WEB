<div class="{{$class}}">
    @foreach ($playlists as $playlist)
        <livewire:playlist-card :$playlist :key="$playlist->id" class="mt-3"/>
    @endforeach
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
