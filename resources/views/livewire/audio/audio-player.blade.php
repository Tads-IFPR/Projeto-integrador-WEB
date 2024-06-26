<div id="player-controls" style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;">
    <div id="audio-data" class="d-flex align-items-center w-20">
        @if ($audio)
            <img id="audio-card" width="45px" src="{{route('audio.show.image', $audio)}}" alt="Audio cover image">
            <div class="d-flex flex-column align-items-left justify-content-start h-100 px-2">
                <h3>{{$audio?->name}}</h3>
                <h4>{{$audio?->author}}</h4>
            </div>
        @endif
    </div>

    <div id="controls" class="w-60 d-flex flex-column align-items-center justify-content-center">
        <div id="actions" class="d-flex justify-content-center">
            @if ($audio?->previous)
                <button id="previous" class="button-icon" wire:click='previous'>
                    <span class="material-symbols-outlined">
                        skip_previous
                    </span>
                </button>
            @else
                <div></div>
            @endif
            <button onclick="play()" id="play" class="button-icon">
                <span class="material-symbols-outlined">play_arrow</span>
            </button>
            <button onclick="pause()" id="pause" style="display: none" class="button-icon">
                <span class="material-symbols-outlined">
                    pause
                </span>
            </button>
            @if ($audio?->next)
                <button id="next" class="button-icon" wire:click='next'>
                    <span class="material-symbols-outlined">
                        skip_next
                    </span>
                </button>
            @else
                <div></div>
            @endif
        </div>
        <audio id="player" ontimeupdate="changeTime()" onloadedmetadata="loadedAudio()">
            @if ($audio)
                <source src="{{ route('audio.show', $audio) }}" type="audio/mpeg" id="player-source">
                Your browser does not support the audio element.
            @endif
        </audio>

        <div class="d-flex justify-content-between">
            <div class="d-flex">
                <span id="current" class="me-2">0:00</span>
                <input type="range" id="timer" name="timer" min="0" max="0" step="1" oninput="changeTimer()" />
                <span id="end" class="ms-2">0:00</span>
            </div>
        </div>
    </div>

    <div class="w-20 d-flex justify-content-end align-items-center" id="sound">
        <span class="material-symbols-outlined pe-1" id="up" style="display: block" onclick="mute()">
            volume_up
        </span>
        <span class="material-symbols-outlined pe-1" id="off" style="display: none" onclick="unmute()">
            volume_off
        </span>
        <input type="range" id="volume" name="volume" min="0" value="0.1" max="1" step="0.01" oninput="changeVolume()" />
    </div>
</div>

<script>
    const player = document.getElementById('player');
    const current = document.getElementById('current');
    const end = document.getElementById('end');
    const timer = document.getElementById('timer');
    const volume = document.getElementById('volume');
    const playButton = document.getElementById('play');
    const pauseButton = document.getElementById('pause');
    const up = document.getElementById('up');
    const off = document.getElementById('off');
    var isDragging = false;
    var crSrc = null;
    changeVolume()

    function play() {
        pauseButton.style.display = 'block';
        playButton.style.display = 'none';
        player.play();
    }

    function pause() {
        playButton.style.display = 'block';
        pauseButton.style.display = 'none';
        player.pause();
    }

    function mute() {
        volume.value = 0;
        changeVolume();
    }

    function unmute() {
        volume.value = 0.1;
        changeVolume();
    }

    function changeVolume() {
        player.volume = volume.value;
        volume.style.setProperty('--seek-before-width', volume.value / volume.max * 100 + '%');

        if (volume.value == 0) {
            console.log('aqui', volume.value)
            off.style.display = 'block';
            up.style.display = 'none';
        } else {
            console.log('aqui2', volume.value)
            off.style.display = 'none';
            up.style.display = 'block';
        }
    }

    function changeTimer() {
        player.currentTime = timer.value;
        timer.style.setProperty('--player-before-width', timer.value / timer.max * 100 + '%');
    }

    function loadedAudio() {
        if (!player.duration || isNaN(Number(player.duration)) || typeof player.duration !== 'number') {
            return;
        }

        if (crSrc != document.getElementById('player-source').src) {
            crSrc = document.getElementById('player-source').src;
            player.load();
        }
        player.currentTime = 0;
        play();
        timer.max = player.duration;

        const mins = Math.floor(player.duration / 60);
        const seconds = player.duration - (mins * 60);
        const decimalSecond = seconds < 10 ? 0 : '';
        end.innerText = seconds ? mins + ':' + decimalSecond + Math.floor(seconds) : '0:0';
        player.volume = volume.value;
        volume.style.setProperty('--seek-before-width', volume.value / volume.max * 100 + '%');
    }

    function changeTime() {
        timer.value = player.currentTime;
        timer.style.setProperty('--player-before-width', timer.value / timer.max * 100 + '%');
        if (player.currentTime < 60) {
            const decimalSecond = player.currentTime < 10 ? 0 : '';
            current.innerText = '0:' + decimalSecond + Math.floor(player.currentTime);
        } else {
            const mins = Math.floor(player.currentTime / 60);
            const seconds = player.currentTime - (mins * 60);
            const decimalSecond = seconds < 10 ? 0 : '';
            current.innerText = mins + ':' + decimalSecond + Math.floor(seconds);
        }

        if (player.currentTime === player.duration) {
            reset();
        }
    }

    function reset() {
        pause();
        player.currentTime = 0;
    }
</script>
