<div class="playlist-card d-flex justify-content-between px-1 {{$class}}" style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;">
    <div class="d-flex justify-content-center align-items-center" style="min-width: 50px">
        <img width="50px" src="{{ route('playlist.show.image', $playlist) }}" class="h-100" alt="Playlist cover image">
        <a href="{{ route('playlist.show', $playlist->id) }}" class="play"></a>
    </div>
    <div class="d-flex flex-column ps-3 pe-1 w-100">
        <button wire:click='play' class="play">
            <h3 class="name">{{ $playlist->name }}</h3>
        </button>
        <div>
        @if($playlist->audios->count() > 0)

            <span class="badge">{{ $playlist->audios->count() }} Audios</span>
        @endif
    </div>
    </div>
    <div class="options-playlist" target="{{$playlist->id}}" wire:prevent>
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
            <path d="M480-160q-33 0-56.5-23.5T400-240q0-33 23.5-56.5T480-320q33 0 56.5 23.5T560-240q0 33-23.5 56.5T480-160Zm0-240q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm0-240q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Z"/>
        </svg>
    </div>
    <div id="backdrop-playlist-{{$playlist->id}}" target="{{$playlist->id}}" class="backdrop-playlist" style="display: none;"></div>
    <div id="option-playlist-{{$playlist->id}}" class="option-playlist flex-column align-items-center" style="display: none;">
        <form action="{{ route('playlist.destroy', $playlist->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="d-flex align-items-center">
                <span class="material-symbols-outlined me-1">
                    delete
                </span>
                Delete
            </button>
        </form>
        <div>
            <a href="{{ route('playlist.edit', $playlist->id) }}" wire:navigate class="d-flex align-items-center">
                <span class="material-symbols-outlined me-1">
                    edit
                </span>
                Edit
            </a>
        </div>
        <div>
            <span class="material-symbols-outlined me-1">
                add_circle
            </span>
            <span data-bs-toggle="modal" data-bs-target="#add-rem-{{ $playlist->id }}">
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
    <div class="modal fade" id="add-rem-{{ $playlist->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: dark-gray;">
                <div class="modal-header" style="background-color: black;">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Music</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #A9A9A9;">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <h1 id="playlist-name">{{ $playlist->name }}</h1>

                    @if($audiosNotInPlaylist->isEmpty())
                        <p>No Aduios to be added.</p>
                    @else
                    <form method="POST" action="{{ route('playlist.addAudio') }}" target="hidden-iframe-{{ $playlist->id }}">
                    @csrf
                            <input type="hidden" name="playlist_id" value="{{ $playlist->id }}" >
                            <div class="container">
                                <div class="row">
                                    @foreach($audiosNotInPlaylist as $audio)


                                        <div class="col-md-6 mb-3" id="card-add">
                                            <div class="card">
                                                <div class="card-body d-flex">
                                                    <div class="d-flex justify-content-center align-items-center" style="min-width: 50px">
                                                        <img src="{{ route('audio.show.image', $audio) }}" class="h-100" alt="Audio cover image" id="img-audio">
                                                    </div>
                                                    <div class="d-flex flex-column ps-3 pe-1 w-100">
                                                        <h5 class="card-title mb-1" id="audio-name">{{ $audio->name }}</h5>
                                                        <p class="card-text mb-2" id="author">{{ $audio->author }} </p>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="audio_ids[]" value="{{ $audio->id }}" id="audio-{{ $audio->id }}">
                                                            <label class="form-check-label" for="audio-{{ $audio->id }}">
                                                                Select
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center" style="height: 5%;">
                                        <button type="submit" class="btn btn-primary mt-3">Add</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                    <iframe name="hidden-iframe-{{ $playlist->id }}" style="display:none;" onload="closeModalOnSuccess('{{ $playlist->id }}')"></iframe>
                </div>
                <div class="modal-footer" style="background-color: black;">
                    <button type="button" id="close-modal-btn" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var processedPlaylists = new Set();

        window.addEventListener('audioAdded', function (event) {
            var playlistId = event.detail.playlistId;
            if (processedPlaylists.has(playlistId)) {
                console.log('Evento já processado para playlistId:', playlistId);
                return;
            }
            processedPlaylists.add(playlistId);

            var myModal = bootstrap.Modal.getInstance(document.getElementById('add-rem-' + playlistId));
            myModal.hide();

            var checkboxes = document.querySelectorAll('#add-rem-' + playlistId + ' input[type="checkbox"]:checked');
            console.log('Checkboxes encontrados:', checkboxes.length);
            checkboxes.forEach(function (checkbox) {
                var audioId = checkbox.value;
                console.log('Checkbox value:', audioId);
                var label = document.querySelector('label[for="audio-' + audioId + '"]');
                if (label) {
                    console.log('Label encontrado:', label);
                    label.textContent = 'Adicionado';

                    label.style.display = 'none';
                    label.offsetHeight;
                    label.style.display = '';
                }
                checkbox.disabled = true;
            });
        });

        var iframes = document.querySelectorAll('iframe');
        iframes.forEach(function(iframe) {
            iframe.onload = function() {
                var playlistId = iframe.getAttribute('name').split('-').pop();
                closeModalOnSuccess(playlistId);
            };
        });
    });

    function closeModalOnSuccess(playlistId) {
        var iframe = document.querySelector('iframe[name="hidden-iframe-' + playlistId + '"]');
        var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

        if (iframeDoc.body.innerHTML.trim().includes('success')) {
            var event = new CustomEvent('audioAdded', { detail: { playlistId: playlistId } });
            window.dispatchEvent(event);
        }
    }
</script>

@push('styles')

<style>
    .container{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;

    }
    .modal-header {
        display: flex;
        justify-content: center;
    }

    .modal-header button {
        color: white;
    }

    .card-body {
        padding: 0.2rem;
    }

    .card-title {
        font-size: 1.25rem;
    }
    .modal-header h5 {
        color: white;
    }

    .modal-header button {
        color: white;
    }

    .modal-content {
        background-color: #A9A9A9;
    }

    .modal-body {
        height: 60vh;
        overflow: auto;
    }

    .modal-footer {
        display: flex;
        justify-content: center;
    }

    .modal-footer button {
        width: 100px;
    }

    .card {
        background-color: #696969;
        color: white;
    }

    .card-title {
        font-size: 1.25rem;
    }

    .card-text {
        font-size: 1rem;
    }

    .form-check {
        margin-bottom: 0;
    }

    .form-check-input {
        margin-top: 0.5rem;
    }

    .form-check-label {
        margin-top: 0.5rem;
    }

    .btn-primary {
        background-color: #13F2A1;
        border-color: black;
        color: black;
        font-weight: bold;
        height: 3rem;
        width: 3rem;
        font-size: 0.6rem;
    }

    .btn-primary:hover {
        background-color: #13F2A1;
        border-color: black;
    }


    #author {
        font-size: 0.8rem;
    }

    #audio-name {
        font-size: 1rem;
        padding: auto;
    }

    #img-audio {
        width: 10rem;
        height: 10rem;
        max-height: 10rem;
    }

    #card-add {
        margin-top: 0.2rem;
        height: 10rem;
        width: 30rem;
    }

    #playlist-name{
        font-size: 1.5rem;
        font-weight: bold;
    }


</style>

@endpush
