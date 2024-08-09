<div id="player-controls"
    @class(['have-audio' => !!$audio, 'expanded' => $isPlaying])
    style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;"
>
    <div id="audio-data" class="d-flex align-items-center">
        @if ($audio)
            <img id="audio-card" width="50px"
            src="{{ $audio->cover_path !== null ? route('audio.show.image', $audio) : '/imgs/wave-sound-big.png'}}"
            @style(['filter: invert(1)' => $audio->cover_path === null])
            alt="Audio cover image">
            <div class="d-flex flex-column align-items-left justify-content-start h-100 px-2" id="audio-name">
                <h3><strong>{{$audio?->name}}</strong></h3>
                <h4>{{$audio?->author}}</h4>
            </div>
        @endif
    </div>

    <div id="controls" class="d-flex flex-column align-items-center justify-content-center">
        <div id="actions" class="d-flex justify-content-center">
            <button class="button-icon me-2" wire:click="toggleShuffle" id="shuffle">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="{{$isShuffle ? 'var(--primary)' : 'var(--white)'}}"
                >
                    <path d="M560-160v-80h104L537-367l57-57 126 126v-102h80v240H560Zm-344 0-56-56 504-504H560v-80h240v240h-80v-104L216-160Zm151-377L160-744l56-56 207 207-56 56Z"/>
                </svg>
            </button>
            @if ($audio?->previous)
                <button id="previous" class="button-icon" wire:click='previous' onclick="stopPropagation(event)">
                    <span class="material-symbols-outlined">
                        skip_previous
                    </span>
                </button>
            @else
                <div></div>
            @endif
            <button onclick="play(event)" id="play" class="button-icon">
                <span class="material-symbols-outlined">play_arrow</span>
            </button>
            <button onclick="pause(event)" id="pause" style="display: none" class="button-icon">
                <span class="material-symbols-outlined">
                    pause
                </span>
            </button>
            @if ($audio?->next)
                <button id="next" class="button-icon" wire:click='next' onclick="stopPropagation(event)">
                    <span class="material-symbols-outlined">
                        skip_next
                    </span>
                </button>
            @else
                <div></div>
            @endif
        </div>
        <audio id="player" ontimeupdate="changeTime()" onloadedmetadata="loadedAudio()" target="{{$audio?->id}}">
            @if ($audio)
                <source src="{{ route('audio.show', $audio) }}" type="audio/mpeg" id="player-source">
                Your browser does not support the audio element.
            @endif
        </audio>

        <div class="d-flex justify-content-between" id="time-controls" onclick="stopPropagation(event)">
            <div class="d-flex">
                <span id="current" class="me-2">0:00</span>
                <input type="range" id="timer" name="timer" min="0" max="0" step="1" oninput="changeTimer()" />
                <span id="end" class="ms-2">0:00</span>
            </div>
            <div id="mobile-timer"></div>
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
    var player = document.getElementById('player');
    var current = document.getElementById('current');
    var end = document.getElementById('end');
    var timer = document.getElementById('timer');
    var volume = document.getElementById('volume');
    var playButton = document.getElementById('play');
    var pauseButton = document.getElementById('pause');
    var up = document.getElementById('up');
    var off = document.getElementById('off');
    var timeControls = document.getElementById('time-controls');
    var crSrc = null;
    var userInteracted = false;
    const state = JSON.parse(localStorage.getItem('playerState'));

    function userInteraction() {
        userInteracted = true;
        document.removeEventListener('click', userInteraction);
        document.removeEventListener('keydown', userInteraction);
    }

    document.addEventListener('click', userInteraction);
    document.addEventListener('keydown', userInteraction);

    function loadPlayerState() {
        if (state && state?.currentSongId) {
            @this.call('startLastAudio', state.currentSongId);

            player.volume = state.volume;
            volume.value = state.volume;

            changeVolume();
        }
    }

    function savePlayerState() {
        if (crSrc != null) {
            const state = {
                currentSongId: player.attributes.target.value,
                currentTime: player.currentTime,
                currentDuration: player.duration,
                volume: player.volume,
                isPlaying: !player.paused
            };
            localStorage.setItem('playerState', JSON.stringify(state));
        }
    }

    window.addEventListener('beforeunload', savePlayerState);
    document.addEventListener('DOMContentLoaded', loadPlayerState);

    function stopPropagation(event) {
        event?.stopPropagation();
    }

    function playNext() {
        @this.addPlayedMusic();
        document.getElementById('next')?.click();
    }

    function play(event = null) {
        event?.stopPropagation();
        pauseButton.style.display = 'block';
        playButton.style.display = 'none';
        player.play();
    }

    function pause(event = null) {
        event?.stopPropagation();
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
            off.style.display = 'block';
            up.style.display = 'none';
        } else {
            off.style.display = 'none';
            up.style.display = 'block';
        }
    }

    function changeTimer() {
        player.currentTime = timer.value;
        timeControls.style.setProperty('--player-before-width', timer.value / timer.max * 100 + '%');
    }

    function loadedAudio() {
        if (!player.duration || isNaN(Number(player.duration)) || typeof player.duration !== 'number') {
            return;
        }

        if (crSrc != document.getElementById('player-source').src) {
            crSrc = document.getElementById('player-source').src;
            player.load();
        }

        if (userInteracted) {
            play();
        }

        timer.max = player.duration;

        const mins = Math.floor(player.duration / 60);
        const seconds = player.duration - (mins * 60);
        const decimalSecond = seconds < 10 ? 0 : '';
        end.innerText = seconds ? mins + ':' + decimalSecond + Math.floor(seconds) : '0:0';
        player.volume = volume.value;
        volume.style.setProperty('--seek-before-width', volume.value / volume.max * 100 + '%');
        savePlayerState();
    }

    function changeTime() {
        timer.value = player.currentTime;
        timeControls.style.setProperty('--player-before-width', timer.value / timer.max * 100 + '%');
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
            playNext();
        }
    }

    function reset() {
        pause();
        player.currentTime = 0;
    }

    function toggleMobilePlayer(event = null) {
        event.stopPropagation();
        @this.togglePlaying();

        let elements = document.getElementsByClassName('black-background');
        Array.from(elements).forEach(element => {
            element.removeEventListener('click', toggleMobilePlayer)
        });

        document.body.classList.toggle('black-background');

        setTimeout(() => {
            let elements = document.getElementsByClassName('black-background');
            Array.from(elements).forEach(element => {
                element.addEventListener('click', toggleMobilePlayer)
            })
        }, 250);
    }

    function updateSize() {
        const playerControls = document.getElementById('player-controls');

        if (window.innerWidth <= 500 ) {
            playerControls.addEventListener('click', toggleMobilePlayer);
        } else {
            playerControls?.removeEventListener('click', toggleMobilePlayer)
        }
    }

    window.addEventListener('resize', updateSize);
    updateSize();
</script>
