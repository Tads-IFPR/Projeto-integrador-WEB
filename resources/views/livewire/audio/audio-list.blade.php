<div class="{{$class}}">
    @foreach ($audios as $audio)
        <livewire:audio-card :$audio :key="$audio->id" class="mt-3"/>
    @endforeach
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
</script>
