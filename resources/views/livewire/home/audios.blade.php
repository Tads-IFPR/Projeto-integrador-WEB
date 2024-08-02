<div class="d-flex flex-column" id="audios">
    <div class="d-flex justify-content-between w-100">
        <h2 class="cfs-1 bolder">Musics</h2>
        <a href="{{route('audio.create')}}" class="button-default px-4 py-1" wire:navigate>New</a>
    </div>
    <div class="d-flex w-100 wrap">
        @foreach ($audios as $audio)
            <livewire:audio-card :$audio :key="$audio->id" class="mt-3"/>
        @endforeach
    </div>
</div>

<script>
    let backdropListeners = {};

    const toggleDropDownAudio = (target) => {
        const backdropAudio = document.getElementById('backdrop-audio-' + target);
        const options = document.getElementById('option-audio-' + target);

        if (options.style.display === 'none' || options.style.display === '') {
            options.style.display = 'flex';
            backdropAudio.style.display = 'block';

            if (!backdropListeners[target]) {
                backdropAudio.addEventListener('click', () => toggleDropDownAudio(target, true));
                backdropListeners[target] = true;
            }
        } else {
            options.style.display = 'none';
            backdropAudio.style.display = 'none';
        }
    }

    const options = document.getElementsByClassName('options-audio');
    Array.from(options).forEach(option => {
        option.addEventListener('click', () => toggleDropDownAudio(option.attributes.target.nodeValue));
    });
</script>
